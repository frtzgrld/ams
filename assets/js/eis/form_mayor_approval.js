

    $(document).ready(function () {
        $("#form_mayor_approval").validate({
            ignore:'',
            rules: {
                hidden_ref_index_cma: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                hidden_ref_type_cma: {
                    required: true,
                    maxlength: 50,
                },
                action_cma: {
                    required: true,
                    maxlength: 10,
                },
                cma_date_signed: {
                    required: false,
                    maxlength: 30,
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'executive/validate_mayors_approval',
                    method: 'POST',
                    data: $('#form_mayor_approval').serialize(),
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

    function toggleCMAModal( form_type, obre_id )
    {
        $('#action_cma').val('insert');
        $('#hidden_ref_index_cma').val( obre_id );
        $('#hidden_ref_type_cma').val( form_type );
        
        $('#hidden_cma_button').click();
    }