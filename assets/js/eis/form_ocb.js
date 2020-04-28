

    $(document).ready(function () {
        $("#form_ocb").validate({
            ignore:'',
            rules: {
                hidden_ref_index_ocb: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                hidden_ref_type_ocb: {
                    required: true,
                    maxlength: 50,
                },
                action_ocb: {
                    required: true,
                    maxlength: 10,
                },
                ocb_amount: {
                    required: false,
                    maxlength: 30,
                    number: true
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'budget/outgoing_control_book/validate_outgoing_request',
                    method: 'POST',
                    data: $('#form_ocb').serialize(),
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
                                setTimeout(function(){
                                    swal(response['header'], response['message'], "success");
                                },  500 );
                                setTimeout(function(){
                                    window.location.reload();
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

    function toggleOCBModal( form_type, obre_id, amount )
    {
        $('#action_ocb').val('insert');
        $('#hidden_ref_index_ocb').val( obre_id );
        $('#hidden_ref_type_ocb').val( form_type );
        $('#ocb_amount').val( add_commas(parseFloat(amount).toFixed(2)) );
        
        $('#hidden_ocb_button').click();
    }