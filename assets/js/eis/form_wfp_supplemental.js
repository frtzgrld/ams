
    $(document).ready(function () {

        // addParticular(1,1);

        $("#form_wfp_supplemental").validate({
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
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'budget/work_and_financial_plan/validate_wfp_adjustment',
                    method: 'POST',
                    data: $('#form_wfp_supplemental').serialize(),
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
                                    // if(response['redirect'])
                                        // window.location.href = response['redirect'];
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
        var supplemental = ($('#wfp_item_type').val()=='supplemental') ? '' : '<tr id="alignment_row_'+allotment+'_'+row_no+'">' +
                    '<td></td>' +
                    '<td colspan="4">' +
                        '<table class="table">' +
                            '<thead class="table-eis">' +
                                '<tr>' +
                                    '<th style="width: 70%"><i>Realigned from:</i></th>' +
                                    '<th style="width: 25%"><i>Amount</i></th>' +
                                    '<th style="width: 05%"></th>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody id="tbody_alignment_row_'+allotment+'_'+row_no+'">' +

                            '</tbody>' +
                            '<tfoot>' +
                                '<tr>' +
                                    '<td></td>' +
                                    '<td></td>' +
                                    '<td>' +
                                        '<input type="hidden" id="hidden_alignment_ctr_'+row_no+'" value="1">' +
                                        '<button class="btn btn-block btn-default" type="button" onclick="add_realignment('+allotment+','+row_no+', 1)" ' +
                                            'id="btn_alignment_ctr_'+allotment+'_'+row_no+'">' +
                                            '<i class="fa fa-plus"></i>' +
                                        '</button>' +
                                    '</td>' +
                                '</tr>' +
                            '</tfoot>' +
                        '</table>' +
                    '</td>' +
                '</tr>';

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
                '</tr>' + supplemental
            );

        $('#particulars_'+allotment+'_'+row_no).select2();

        loadParticulars('particulars_', row_no, allotment);

        $('#hidden_row_counter_'+allotment).val( row_no+1 );

        $('#hidden_add_exp_btn_'+allotment).attr('onclick', 'addParticular('+(row_no+1)+', '+allotment+')')
    }

    function loadParticulars( id, row_count, allotment, align_row_no=null, in_id=null )
    {
        $.ajax({
            url: base_url + 'budget/work_and_financial_plan/xhr_wfp_particulars',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {allotment: allotment, in_id: in_id},
            async: true,
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                if( align_row_no )
                {
                    if(response.length == 0) {
                        $('#'+id+allotment+'_'+row_count+'_'+align_row_no).html("No record found");
                    } else {
                        $('#'+id+allotment+'_'+row_count+'_'+align_row_no).empty();
                        $.each(response, function(index, value){
                            if( response[index]['SELECTABLE'] != null )
                                $('#'+id+allotment+'_'+row_count)
                                    .append($("<option></option>")
                                    .attr("value",response[index]['ACCOUNT_LIST_ID'])
                                    .text(response[index]['ACCOUNT_CODE']+': '+response[index]['ACCOUNTS'])); 
                        });
                    }
                }
                else
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
            }
        });
    }

    function add_realignment( allotment, row_no, align_row_no )
    {
        $('#tbody_alignment_row_'+allotment+'_'+row_no).append(
                '<tr>' +
                    '<td>' +
                        '<select class="select2 form-control" id="realign_item_' + allotment + '_' + row_no + '_' + align_row_no + 
                            '" name="aligning_particulars_'+allotment+'_'+row_no+'[]">' +
                        '</select>' +
                    '</td>' +
                    '<td>' +
                        '<input type="text" class="form-control text-right" name="" readonly="" value="">' +
                    '</td>' +
                    '<td>' +
                        '<button class="btn btn-block btn-trans btn-pink" type="button" onclick="">' +
                            '<i class="fa fa-trash-o"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>'
            );

        $('#realign_item_' + allotment + '_' + row_no + '_' + align_row_no).select2();

        loadParticulars('realign_item_', row_no, allotment, align_row_no, $('#hidden_wfp_id').val());

        $('#hidden_alignment_ctr_'+row_no).val( align_row_no+1 );

        $('#btn_alignment_ctr_'+allotment+'_'+row_no).attr('onclick', 'add_realignment('+allotment+', '+row_no+', '+(align_row_no+1)+')');
    }