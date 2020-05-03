
                $(document).ready(function () {

                    $("#form_checks_cancel").validate({
                        ignore:'',
                        rules: {
                            hidden_check_id: {
                                required: true,
                                maxlength: 11,
                                number: true,
                            },
                            action: {
                                required: true,
                                maxlength: 6,
                            },
                            cancelled_date: {
                                required: true,
                                maxlength: 30,
                            },
                            cancel_remark: {
                                required: true,
                                maxlength: 5000,
                            },
                        },

                        errorPlacement: function (error, element) {
                            $(element).closest('.form-group').find('.error-message').html(error);
                        },

                        submitHandler: function() {
                            $.ajax({
                                url: base_url + 'funds/checks_management/validate_checks_cancellation',
                                method: 'POST',
                                data: $('#form_checks_cancel').serialize(),
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