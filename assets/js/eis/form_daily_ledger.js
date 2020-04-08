

    $(document).ready(function () {
        $("#form_daily_ledger").validate({
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
                    url: base_url + 'enterprise/validate_daily_rental',
                    method: 'POST',
                    data: $('#form_daily_ledger').serialize(),
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

    function getTotal()
    {
        var total = 0;

        for(var i=1; i<=$('#total_record').val(); i++)
        {
            amount = $('#daily_rental_'+i).val();
            amount = ( amount=='' || amount==null) ? 0 : amount;
            total += parseFloat((amount).replace(',', ''));
        }

        $('#total_collection').val(add_commas(parseFloat(total).toFixed(2)));
    }