

    $(document).ready(function () {
        $("#form_icb").validate({
            ignore:'',
            rules: {
                hidden_ref_index_icb: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                hidden_ref_type_icb: {
                    required: true,
                    maxlength: 50,
                },
                action_icb: {
                    required: true,
                    maxlength: 10,
                },
                refno: {
                    required: false,
                    maxlength: 30,
                    remote: {
                        url: base_url+'budget/unique_ref_no',
                        type: "post",
                        data: {
                            refid: function() {
                                return $("#hidden_ref_index_icb").val();
                            },
                            reftype: function() {
                                return $("#hidden_ref_type_icb").val();
                            }
                        }
                    }
                },
                icb_amount: {
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
                    url: base_url + 'budget/incoming_control_book/validate_incoming_request',
                    method: 'POST',
                    data: $('#form_icb').serialize(),
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

    function toggleICBModal( form_type, obre_id, amount )
    {
        $('#action_icb').val('insert');
        $('#hidden_ref_index_icb').val( obre_id );
        $('#hidden_ref_type_icb').val( form_type );
        $('#refno').attr('data-mask', "99-9999");
        $('#icb_amount').val( add_commas(parseFloat(amount).toFixed(2)) );
        
        $('#hidden_icb_button').click();
    }