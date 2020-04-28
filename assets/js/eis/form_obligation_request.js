
                $(document).ready(function () {

                    $("#form_obligation_request").validate({
                        ignore:'',
                        rules: {
                            hidden_obre_id: {
                                required: true,
                                maxlength: 11,
                                number: true,
                            },
                            action: {
                                required: true,
                                maxlength: 6,
                            },
                            obre_no: {
                                required: true,
                                maxlength: 50,
                                remote: {
                                    url: base_url+'budget/obligation_requests/unique_obre_no',
                                    type: "post",
                                    data: {
                                        obre_id: function() {
                                            return $("#hidden_obre_id").val();
                                        }
                                    }
                                }
                            },
                            payee: {
                                required: true,
                                maxlength: 250,
                            },
                            office: {
                                required: false,
                                maxlength: 250,
                            },
                            address: {
                                required: true,
                                maxlength: 500,
                            },
                            mayor: {
                                required: true,
                                maxlength: 250,
                            },
                            budget_officer: {
                                required: true,
                                maxlength: 250,
                            },
                        },

                        errorPlacement: function (error, element) {
                            $(element).closest('.form-group').find('.error-message').html(error);
                        },

                        submitHandler: function() {
                            $.ajax({
                                url: base_url + 'budget/obligation_requests/validate_obre',
                                method: 'POST',
                                data: $('#form_obligation_request').serialize(),
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

                function toggleDeleteAlert( lot_id )
                {
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this imaginary file!",
                        type: "error",
                        showCancelButton: true,
                        confirmButtonClass: 'btn-danger waves-effect waves-light',
                        confirmButtonText: 'Delete!'
                    });
                }

                function printVoucher( voucher_no )
                {
                    popup_window( base_url + 'file/vouchers/print_voucher/' + voucher_no );
                }

                function addExplanation( row_no )
                {
                    $('#tbl_explanation').append(
                            '<tr id="row' + row_no + '">' +
                                '<td>' +
                                    '<textarea class="form-control" name="explanation[]" id="explanation1" style="height: 100px"></textarea>' +
                                '</td>' +
                                '<td>' +
                                    '<input type="text" name="amount[]" id="amount' + row_no + '" class="form-control text-right text-strong">' +
                                    '<input type="hidden" name="voucher_item[]" id="voucher_item' + row_no + '" ' +
                                        'class="form-control text-right text-strong" value="0">' +
                                '</td>' +
                                '<td>' +
                                    '<button class="btn btn-block btn-default" type="button" onclick="deleteExplanation('+ row_no +')">' +
                                        '<i class="fa fa-trash-o"></i>' +
                                    '</button>' +
                                '</td>' +
                            '</tr>'
                        );

                    $('#hidden_row_counter').val( row_no+1 );
                    $('#hidden_add_exp_btn').attr( 'onclick', 'addExplanation('+(row_no+1)+')' );
                }

                function deleteExplanation( row_no )
                {
                    $('#row' + row_no).remove();
                }

                function putAccountCode( row_no )
                {
                    var account_code = ($('#wfp_particulars'+row_no).val()).split('%2D');

                    $('#accountcode'+row_no).val( account_code[1] );
                }