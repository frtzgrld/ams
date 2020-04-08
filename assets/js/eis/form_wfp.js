
    $(document).ready(function () {

        // addParticular(1,1);

        $("#form_wfp").validate({
            ignore:'',
            rules: {
                hidden_wfp_id: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                action: {
                    required: true,
                    maxlength: 6,
                },
                calendar_year: {
                    required: true,
                    maxlength: 4,
                    number: true,
                },
                office: {
                    required: true,
                    maxlength: 11,
                },
                prepared_by: {
                    required: true,
                    maxlength: 250,
                },
                designation: {
                    required: true,
                    maxlength: 250,
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'budget/work_and_financial_plan/validate_wfp',
                    method: 'POST',
                    data: $('#form_wfp').serialize(),
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

    function toggleDeleteWFPItem( allotment, row_no )
    {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this record!",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger waves-effect waves-light',
            confirmButtonText: 'Delete!'
        },
        function (isConfirm) {
            if(isConfirm){
                $('#row_' + allotment + '_' + row_no).remove();
            }
        });
    }

    function printVoucher( voucher_no )
    {
        popup_window( base_url + 'file/vouchers/print_voucher/' + voucher_no );
    }

    function addParticular( row_no, allotment )
    {
        $('#tbl_particular_'+allotment).append(
                '<tr id="row_'+allotment+'_'+row_no+'">' +
                    '<td>' +
                        '<input type="hidden" name="wfp_items[]" id="wfp_items_'+allotment+'_'+row_no+'" class="form-control text-right text-strong" required="required" value="0">' +
                        '<input type="hidden" name="hidden_allotment[]" id="hidden_allotment_'+allotment+'" class="form-control text-right text-strong" required="required" value="'+allotment+'">' +
                        '<select type="text" name="particulars[]" id="particulars_'+allotment+'_'+row_no+'" class="form-control select2" required="required"></select>' +
                    '</td>' +
                    // '<td>' +
                    //     '<input type="text" name="account_code[]" id="account_code_'+allotment+'_'+row_no+'" class="form-control text-right text-strong">' +
                    // '</td>' +
                    '<td>' +
                        '<input type="text" name="current_year[]" id="current_year_'+allotment+'_'+row_no+'" class="form-control text-right text-strong">' +
                    '</td>' +
                    '<td>' +
                        '<input type="text" name="budget_year[]" id="budget_year_'+allotment+'_'+row_no+'" class="form-control text-right text-strong">' +
                    '</td>' +
                    '<td>' +
                        '<button class="btn btn-block btn-default" type="button" onclick="toggleDeleteWFPItem('+allotment+','+row_no+')">' +
                            '<i class="fa fa-trash-o"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>'
            );

        $('#particulars_'+allotment+'_'+row_no).select2();

        loadParticulars('particulars_', row_no, allotment);

        $('#hidden_row_counter_'+allotment).val( row_no+1 );

        $('#hidden_add_exp_btn_'+allotment).attr('onclick', 'addParticular('+(row_no+1)+', '+allotment+')')
    }

    function loadParticulars( id, row_count, allotment )
    {
        $.ajax({
            url: base_url + 'budget/work_and_financial_plan/xhr_wfp_particulars',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {allotment: allotment},
            async: true,
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                if(response.length == 0) {
                    $('#'+id+allotment+'_'+row_count).html("No record found");
                } else {
                    $('#'+id+allotment+'_'+row_count).empty();
                    $.each(response, function(index, value){
                        if( response[index]['SELECTABLE'] != null )
                            $('#'+id+allotment+'_'+row_count)
                                .append($("<option></option>")
                                .attr("value",response[index]['ACCOUNT_LIST_ID'])
                                .text(response[index]['ACCOUNT_CODE']+': '+response[index]['ACCOUNTS'])); 
                    });
                }
            }
        });
    }