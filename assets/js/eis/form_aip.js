
    $(document).ready(function () {

        // addParticular(1,1);

        $("#form_aip").validate({
            ignore:'',
            rules: {
                hidden_aip_id: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                action: {
                    required: true,
                    maxlength: 6,
                },
                cy: {
                    required: true,
                    maxlength: 4,
                    number: true,
                },
                planning_officer: {
                    required: true,
                    maxlength: 250,
                },
                budget_officer: {
                    required: true,
                    maxlength: 250,
                },
                local_chief: {
                    required: true,
                    maxlength: 250,
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'budget/annual_investment_program/validate_aip',
                    method: 'POST',
                    data: $('#form_aip').serialize(),
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