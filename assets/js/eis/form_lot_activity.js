

            $(document).ready(function () {
                $("#form_lot_activity").validate({
                    ignore:'',
                    rules: {
                        hidden_procurement_id: {
                            required: true,
                            maxlength: 11,
                            number: true,
                        },
                        hidden_lots_id: {
                            required: true,
                            maxlength: 11,
                            number: true,
                        },
                        action: {
                            required: true,
                            maxlength: 6,
                        },
                    },

                    errorPlacement: function (error, element) {
                        $(element).closest('.form-group').find('.error-message').html(error);
                    },

                    submitHandler: function() {
                        $.ajax({
                            url: base_url + 'procurement/lots/validate_lot_schedule',
                            method: 'POST',
                            data: $('#form_lot_activity').serialize(),
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
                                            window.location.href = response['redirect'];
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
