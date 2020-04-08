

            $(document).ready(function () {
                $("#form_charge").validate({
                    ignore:'',
                    rules: {
                        hidden_clientno: {
                            required: true,
                            maxlength: 50,
                        },
                        hidden_con_refno: {
                            required: true,
                            maxlength: 50,
                        },
                        account: {
                            required: true,
                            maxlength: 250,
                        },
                        particulars: {
                            required: true,
                            maxlength: 250,
                        },
                        yearcover: {
                            required: true,
                            maxlength: 4,
                            minlength: 4,
                            number: true,
                        },
                        amount: {
                            required: true,
                            maxlength: 11,
                            number: true,
                        },
                        date: {
                            required: true,
                            maxlength: 30,
                        }
                    },

                    errorPlacement: function (error, element) {
                        $(element).closest('.form-group').find('.error-message').html(error);
                    },

                    submitHandler: function() {
                        $.ajax({
                            url: base_url + 'billing/validate_charges',
                            method: 'POST',
                            data: $('#form_charge').serialize(),
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
                                            // window.location.reload();
                                        },  2000 );
                                        break;

                                    default:
                                        break;
                                }
                            }
                        });
                    }
                });
            });
