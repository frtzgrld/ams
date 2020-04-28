

    $(document).ready(function () {
        $("#form_budget_approval").validate({
            ignore:'',
            rules: {
                hidden_ref_index_budget: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                hidden_ref_type_budget: {
                    required: true,
                    maxlength: 50,
                },
                action_budget: {
                    required: true,
                    maxlength: 10,
                },
                approve_date: {
                    required: false,
                    maxlength: 30,
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'budget/validate_approve_request',
                    method: 'POST',
                    data: $('#form_budget_approval').serialize(),
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

    function toggleBudgetApprovalModal( form_type, ref_index )
    {
        $('#action_budget').val('insert');
        $('#hidden_ref_index_budget').val( ref_index );
        $('#hidden_ref_type_budget').val( form_type );
        // $('#icb_amount').val( add_commas(parseFloat(amount).toFixed(2)) );
        $('#hidden_budget_appoval_button').click();
    }