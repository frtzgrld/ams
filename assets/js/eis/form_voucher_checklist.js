
                $(document).ready(function () {

                    $("#form_voucher_checklist").validate({
                        ignore:'',
                        rules: {
                            hidden_dvc_voucher_id: {
                                required: true,
                                maxlength: 11,
                                number: true,
                            },
                            hidden_dvc_template_slug: {
                                required: true,
                                maxlength: 250,
                            },
                            dvc_checklist: {
                                required: false,
                                maxlength: 11,
                            },
                        },

                        errorPlacement: function (error, element) {
                            $(element).closest('.form-group').find('.error-message').html(error);
                        },

                        submitHandler: function() {
                            $.ajax({
                                url: base_url + 'vouchers/validate_voucher_checklist',
                                method: 'POST',
                                data: $('#form_voucher_checklist').serialize(),
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