
    $("#form_supplier").validate({
        ignore:'',
        rules: {
            hidden_supplier_id: {
                required: true,
                maxlength: 11,
                number: true,
            },
            company: {
                required: true,
                maxlength: 250,
            },
            specialization: {
            	required: true,
            	maxlength: 250,
            },
            contact_person: {
                required: true,
                maxlength: 250,
            },
            contact_no: {
                required: true,
                maxlength: 250,
            },
            email: {
                required: false,
                maxlength: 150,
                email: true,
            },
            address: {
                required: false,
                maxlength: 500,
            },
        },

        errorPlacement: function (error, element) {
            $(element).closest('.form-group').find('.error-message').html(error);
        },

        submitHandler: function() {
            $.ajax({
                url: base_url + 'suppliers/validate_suppliers',
                method: 'POST',
                data: $('#form_supplier').serialize(),
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
                            $('#datatable_suppliers').DataTable().ajax.reload(null, true);
                            setTimeout(function(){
                                swal(response['header'], response['message'], "success");
                            },  500 );
                            setTimeout(function(){
                                if( response['redirect'] )
                                	window.location.href = response['redirect'];
                            },  1500 );
                            break;

                        default:
                            break;
                    }
                }
            });
        }
    });

    function toggleDeleteAlert( supplier_id )
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

    function toggle_supplier( supplier_id )
    {
		$('#hidden_supplier_id').val('0');
        $('#action').val("insert");
		$('#company').val('');
		$('#specialization').val('');
		$('#contact_person').val('');
		$('#contact_no').val('');
		$('#email').val('');
		$('#address').val('');

        if( supplier_id )
        {
            $.ajax({
                url: base_url + 'suppliers/get_supplier',
                method: 'POST',
                data: {supplier_id: supplier_id},
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
                        $('#hidden_supplier_id').val(response[0]['SUPPLIERID']);
						$('#company').val(response[0]['COMPANYNAME']);
						$('#specialization').val(response[0]['SPECIALIZATION']);
						$('#contact_person').val(response[0]['CONTACTPERSON']);
						$('#contact_no').val(response[0]['CONTACTNO']);
						$('#email').val(response[0]['EMAIL']);
						$('#address').val(response[0]['ADDRESS']);
                    }
                }
            });
        }
        
        $('#hidden_supplier_button').click();
    }