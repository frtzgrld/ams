
    $(document).ready(function () {

        $("#form_source").validate({
            ignore:'',
            rules: {
                hidden_source_id: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                action: {
                    required: true,
                    maxlength: 6,
                },
                fiscal_year: {
                    required: true,
                    maxlength: 4,
                    number: true,
                    remote: {
                        url: base_url+'budget/sources_of_fund/validate_unique_fiscal_year',
                        type: "post",
                        data: {
                            hidden_source_id: function() {
                                return $("#hidden_source_id").val();
                            }
                        }
                    }
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'budget/sources_of_fund/validate_sources_of_fund',
                    method: 'POST',
                    data: $('#form_source').serialize(),
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

    function toggleDeleteFundParticular( row_no )
    {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger waves-effect waves-light',
            confirmButtonText: 'Delete!'
        },
        function (isConfirm) {
            if(isConfirm){
                $('#row' + row_no).remove();
            }
        });
    }

    function addFundParticular( row_no  )
    {
        $('#tbl_particular').append(
                '<tr id="row'+row_no+'">' +
                    '<td>' +
                        '<input type="hidden" name="source_items[]" id="source_items_'+row_no+'" class="form-control text-right text-strong" required="required" value="0">' +
                        '<select type="text" name="particulars[]" id="particulars_'+row_no+'" class="form-control select2" required="required"></select>' +
                    '</td>' +
                    '<td>' +
                        '<input type="text" name="amount[]" id="amount_'+row_no+'" class="form-control text-right text-strong">' +
                    '</td>' +
                    '<td>' +
                        '<button class="btn btn-block btn-default" type="button" onclick="toggleDeleteFundParticular('+row_no+')">' +
                            '<i class="fa fa-trash-o"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>'
            );

        $('#particulars_'+row_no).select2();

        loadFundParticulars('particulars_', row_no);

        $('#hidden_row_counter').val( row_no+1 );

        $('#hidden_add_exp_btn').attr('onclick', 'addFundParticular('+(row_no+1)+')')
    }

    function loadFundParticulars( id, row_count )
    {
        $.ajax({
            url: base_url + 'budget/sources_of_fund/xhr_fund_particulars',
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
                    $('#particulars_'+row_count).html("No record found");
                } else {
                    $('#particulars_'+row_count).empty();
                    $.each(response, function(index, value){
                        $('#particulars_'+row_count)
                            .append($("<option></option>")
                            .attr("value",response[index]['ID'])
                            .text(response[index]['DESCRIPTION'])); 
                    });
                }
            }
        });
    }