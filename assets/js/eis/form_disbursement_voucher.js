
                $(document).ready(function () {

                    $("#form_disbursement_voucher").validate({
                        ignore:'',
                        rules: {
                            hidden_voucher_id: {
                                required: true,
                                maxlength: 11,
                                number: true,
                            },
                            hidden_template_id: {
                                required: true,
                                maxlength: 11,
                                number: true,
                            },
                            action: {
                                required: true,
                                maxlength: 6,
                            },
                            voucher_no: {
                                required: true,
                                maxlength: 50,
                            },
                            payment_mode: {
                                required: true,
                                maxlength: 10,
                            },
                            emp_tin_no: {
                                required: false,
                                maxlength: 50,
                            },
                            oblig_req_no: {
                                required: true,
                                maxlength: 50,
                            },
                            payee: {
                                required: true,
                                maxlength: 250,
                            },
                            address: {
                                required: true,
                                maxlength: 250,
                            },
                            resp_office: {
                                required: true,
                                maxlength: 30,
                            },
                            resp_code: {
                                required: true,
                                maxlength: 30,
                            },
                            'explanation[]': {
                                required: true,
                            },
                            'amount[]': {
                                required: true,
                                number: true,
                            },
                            alloted_by: {
                                required: true,
                                maxlength: 30,
                            },
                            alloted_designation: {
                                required: true,
                                maxlength: 150,
                            },
                            alloted_date: {
                                required: false,
                                maxlength: 30,
                            },
                            availed_by: {
                                required: true,
                                maxlength: 30,
                            },
                            availed_designation: {
                                required: true,
                                maxlength: 150,
                            },
                            availed_date: {
                                required: false,
                                maxlength: 30,
                            },
                            approved_by: {
                                required: true,
                                maxlength: 30,
                            },
                            approved_designation: {
                                required: true,
                                maxlength: 150,
                            },
                            approved_date: {
                                required: false,
                                maxlength: 30,
                            },
                            checkno: {
                                // required: function(element) {
                                //     return ($("#payment_mode").val() == 'check');
                                // },
                                required: false,
                                maxlength: 30,
                            },
                            bank_name: {
                                // required: function(element) {
                                //     return ($("#payment_mode").val() == 'check');
                                // },
                                required: false,
                                maxlength: 250,
                            },
                            check_date: {
                                // required: function(element) {
                                //     return ($("#payment_mode").val() == 'check');
                                // },
                                required: false,
                                maxlength: 50,
                            },
                            received_by: {
                                required: false,
                                maxlength: 250,
                            },
                            received_date: {
                                required: false,
                                maxlength: 30,
                            },
                            or_other_doc: {
                                required: false,
                                maxlength: 100,
                            },
                            jev_no: {
                                required: false,
                                maxlength: 50,
                            },
                            other_doc_date: {
                                required: false,
                                maxlength: 30,
                            },
                        },

                        errorPlacement: function (error, element) {
                            $(element).closest('.form-group').find('.error-message').html(error);
                        },

                        submitHandler: function() {
                            $.ajax({
                                url: base_url + 'vouchers/validate_voucher',
                                method: 'POST',
                                data: $('#form_disbursement_voucher').serialize(),
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