

    $(document).ready(function () {

        loadFunds();

        $("#form_move_to_aip").validate({
            ignore:'',
            rules: {
                hidden_aip_id: {
                    required: true,
                    number: true,
                },
                hidden_aip_item_id: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                hidden_wfp_id: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                action: {
                    required: true,
                    maxlength: 250,
                },
                implem_office: {
                    required: false,
                    maxlength: 11,
                },
                implem_office_desc: {
                    required: false,
                    maxlength: 250,
                },
                description: {
                    required: true,
                    maxlength: 2000,
                },
                start_date: {
                    required: true,
                    maxlength: 30,
                },
                comp_date: {
                    required: true,
                    maxlength: 30,
                },
                exp_output: {
                    required: true,
                    maxlength: 2000,
                },
                funding_source: {
                    required: true,
                    maxlength: 11,
                },
                ps: {
                    required: false,
                    maxlength: 11,
                    number: true,
                },
                mooe: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                co: {
                    required: false,
                    maxlength: 11,
                    number: true,
                },
                cc_adaptation: {
                    required: false,
                    maxlength: 11,
                    number: true,
                },
                cc_mitigation: {
                    required: false,
                    maxlength: 11,
                    number: true,
                },
                cc_typo: {
                    required: false,
                    maxlength: 11,
                }
            },
        
            unhighlight: function(element)
            {
                $(element).closest('.form-group').removeClass('has-error');
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'budget/annual_investment_program/validate_wfp_to_aip',
                    method: 'POST',
                    data: $('#form_move_to_aip').serialize(),
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
                                $('#datatable_offices').DataTable().ajax.reload(null, false);
                                setTimeout(function(){
                                    swal(response['header'], response['message'], "success");
                                },  500 );
                                setTimeout(function(){
                                    window.location.reload();
                                },  1500 );
                                break;

                            default:
                                break;
                        }
                    }
                });
            }
        });
    });

    function toggle_move_to_aip( wfp_id, aip_id )
    {
        clearAIPForm();

        if( wfp_id )
        {
            $.ajax({
                url: base_url + 'budget/annual_investment_program/wfp_summary',
                method: 'POST',
                data: {wfp_id: wfp_id},
                cache: false,
                dataType: 'json',
                async: true,
                error: function(response)
                {
                    alert('error');
                },
                success: function(response)
                {
                    if( response )
                    {
                        $('#action').val('update');
                        $('#hidden_aip_id').val( aip_id );
                        // $('#hidden_aip_item_id').val(  );
                        $('#hidden_wfp_id').val( wfp_id );
                        $('#implem_office').val( response[0]['OFFICEID'] );
                        $('#implem_office_desc').val( response[0]['OFFICE'] );
                        $('#description').val( response[0]['OFFICE']+' (See WFP '+response[0]['OFFICE']+')' );
                        // $('#start_date').val( response[0]['RANK'] );
                        // $('#comp_date').val( response[0]['ACRONYM'] );
                        // $('#exp_output').val(response[0][''])
                        // $('#funding_source').val(response[0]['']);
                        $('#ps').val(response[0]['PPS']);
                        $('#mooe').val(response[0]['MOOE']);
                        $('#co').val(response[0]['CO']);
                        // $('#cc_adaptation').val(response[0]['']);
                        // $('#cc_mitigation').val(response[0]['']);
                        // $('#cc_typo').val(response[0]['']);
                    }
                }
            });
        }
        
        $('#hidden_aip_button').click();
    }

    function clearAIPForm()
    {
        $('#hidden_aip_item_id').val('0');
        $('#hidden_wfp_id').val('0');
        $('#action').val("insert");
        $('#implem_office').val('');
        $('#implem_office_desc').val('');
        $('#description').val('');
        $('#start_date').val('');
        $('#comp_date').val('');
        $('#exp_output').val('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $('#ps').val('');
        $('#mooe').val('');
        $('#co').val('')
        $('#cc_adaptation').val('');
        $('#cc_mitigation').val('');
        $('#cc_typo').val('');
    }


    function loadFunds( id, row_count )
    {
        $.ajax({
            url: base_url + 'funds/xhr_fund_list',
            method: 'POST',
            cache: false,
            dataType: 'json',
            async: true,
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                if(response.length == 0) {
                    $('#funding_source').html("No record found");
                } else {
                    $('#funding_source').empty();
                    $.each(response, function(index, value){
                        $('#funding_source')
                            .append($("<option></option>")
                            .attr("value",response[index]['ID'])
                            .text(response[index]['DESCRIPTION'])); 
                    });
                }
            }
        });
    }