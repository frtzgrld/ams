
    $(document).ready(function () {
        $("#form_item").validate({
            ignore:'',
            rules: {
                hidden_item_id: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                action: {
                    required: true,
                    maxlength: 6,
                },
                category: {
                    required: true,
                    maxlength: 30,
                },
                item_code: {
                    required: true,
                    maxlength: 30,
                },
                parent: {
                    required: false,
                    maxlength: 11,
                },
                description: {
                    required: true,
                    maxlength: 250,
                },
                unit: {
                    required: false,
                    maxlength: 50,
                },
                minqty: {
                    required: false,
                    maxlength: 11,
                    number: true,
                },
                maxqty: {
                    required: false,
                    maxlength: 11,
                    number: true,
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'items/validate_item',
                    method: 'POST',
                    data: $('#form_item').serialize(),
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
                                $('#datatable_items').DataTable().ajax.reload(null, false);
                                setTimeout(function(){
                                    swal(response['header'], response['message'], "success");
                                },  500 );
                                setTimeout(function(){
                                    if( response['redirect'] )
                                        window.location.href = response['redirect'];
                                },  1500 );
                                break;

                            case 'error':
                            default:
                                swal(response['header'], response['message'], "error");
                                break;
                        }
                    }
                });
            }
        });
    });

    function toggleDeleteAlert( item_id )
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

    function toggle_items( item_id )
    {
        $('#hidden_item_id').val('0');
        $('#action').val("insert");
        $('#category').val('').trigger('change');
        $('#item_code').val('');
        $('#parent').val(0).trigger('change');
        $('#description').val('');
        $('#unit').val('');
        $('#minqty').val('');
        $('#maxqty').val('');

        if( item_id )
        {
            $.ajax({
                url: base_url + 'items/load_item',
                method: 'POST',
                data: {item_id: item_id},
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
                        $('#hidden_item_id').val(response[0]['ID']);
                        $('#action').val("update");
                        $('#category').val(response[0]['CATEGORY']).trigger('change');
                        $('#item_code').val(response[0]['CODE']);
                        $('#parent').val(response[0]['PARENT']).trigger('change');
                        $('#description').val(response[0]['DESCRIPTION']);
                        $('#unit').val(response[0]['UNIT']);
                        $('#minqty').val(response[0]['MINQTY']);
                        $('#maxqty').val(response[0]['MAXQTY']);
                    }
                }
            });
        }
        
        $('#hidden_item_button').click();
    }