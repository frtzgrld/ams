
                $(document).ready(function () {

                    var output = $('#concessionaire_search_result');

                    $("#form_search_concessionaire").validate({
                        ignore:'',
                        rules: {
                            concessionaire: {
                                required: true,
                                maxlength: 250,
                            },
                        },

                        errorPlacement: function (error, element) {
                            $(element).closest('.form-group').find('.error-message').html(error);
                        },

                        submitHandler: function() {
                            $.ajax({
                                url: base_url + 'billing/validate_search_concessionaire',
                                method: 'POST',
                                data: $('#form_search_concessionaire').serialize(),
                                cache: false,
                                dataType: 'json',
                                async: true,
                                error: function(response)
                                {
                                    alert('error');
                                },
                                success: function(response)
                                {
                                    output.html(
                                            '<tr>' +
                                                '<td colspan="4" class="text-center">' +
                                                    '<i class="fa fa-spinner fa-spin"></i> loading...' +
                                                '</td>' +
                                            '</tr>'
                                        );

                                    setTimeout(function(){
                                        if( response.constructor == Array )
                                        {
                                            for (var i = 0; i < response.length; i++) 
                                            {
                                                output.html(
                                                        '<tr>' +
                                                            '<td>' + response[i]['CLIENTNO'] + '</td>' +
                                                            '<td>' + response[i]['CONCESSION_REFNO'] + '</td>' +
                                                            '<td>' + response[i]['CONCESSIONAIRE'] + '</td>' +
                                                            '<td>' +
                                                                '<a class="btn btn-block btn-xs btn-trans btn-success" href="' + 
                                                                    base_url + 'billing/charges/' + response[i]['CONCESSION_REFNO'] + '">' +
                                                                    'PROCEED TO BILLING' +
                                                                '</a>' +
                                                            '</td>' +
                                                        '</tr>'
                                                    );
                                            }

                                            $('#count_result').html('Result: ' + response.length);
                                        }
                                        else
                                        {
                                            output.html(
                                                    '<tr>' +
                                                        '<td colspan="4" class="text-center">NO RESULT FOUND</td>' +
                                                    '</tr>'
                                                );

                                            $('#count_result').html('No result');
                                        }
                                    },  1000);
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