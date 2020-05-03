
                $(document).ready(function () {

                    $("#form_check_status").validate({
                        ignore:'',
                        rules: {
                            hidden_check_no: {
                                required: true,
                                maxlength: 30,
                            },
                            status: {
                                required: true,
                                maxlength: 30,
                            },
                        },

                        errorPlacement: function (error, element) {
                            $(element).closest('.form-group').find('.error-message').html(error);
                        },

                        submitHandler: function() {
                            $.ajax({
                                url: base_url + 'funds/checks_management/validate_checks_status',
                                method: 'POST',
                                data: $('#form_check_status').serialize(),
                                cache: false,
                                dataType: 'json',
                                async: true,
                                error: function(response)
                                {
                                    alert('error');
                                },
                                success: function(response)
                                {
                                    Custombox.close();
                                    switch( response['result'] )
                                    {
                                        case 'success':
                                            swal(response['header'], response['message'], "success");
                                            setTimeout(function(){
                                                if(response['redirect'])
                                                    window.location.href = response['redirect'];
                                            },  1000 );
                                            break;

                                        default:
                                            break;
                                    }
                                }
                            });
                        }
                    });
                });