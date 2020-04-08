
                $(document).ready(function () {

                    $("#form_checks_logbook").validate({
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
                            fund: {
                                required: true,
                                maxlength: 30,
                            },
                            checkno: {
                                required: true,
                                maxlength: 30,
                            },
                            bank: {
                                required: true,
                                maxlength: 150,
                            },
                            check_date: {
                                required: true,
                                maxlength: 30,
                            },
                            voucher_no: {
                                required: true,
                                maxlength: 30,
                            },
                            obre_no: {
                                required: true,
                                maxlength: 30,
                            },
                            amount: {
                                required: true,
                                maxlength: 14,
                            },
                            remark: {
                                required: false,
                            },
                        },

                        errorPlacement: function (error, element) {
                            $(element).closest('.form-group').find('.error-message').html(error);
                        },

                        submitHandler: function() {
                            $.ajax({
                                url: base_url + 'funds/checks_management/validate_checks',
                                method: 'POST',
                                data: $('#form_checks_logbook').serialize(),
                                cache: false,
                                dataType: 'json',
                                async: true,
                                error: function(response)
                                {
                                    alert('error');
                                },
                                success: function(response)
                                {
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