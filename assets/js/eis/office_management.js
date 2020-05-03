

            $(document).ready(function () {
                $("#form_office").validate({
                    ignore:'',
                    rules: {
                        hidden_office_id: {
                            required: true,
                            maxlength: 11,
                            number: true,
                        },
                        office_desc: {
                            required: true,
                            maxlength: 250,
                        },
                        office_parent: {
                            required: false,
                            maxlength: 11,
                        },
                        office_ppmp: {
                            required: true,
                            maxlength: 2,
                        },
                        office_rank: {
                            required: true,
                            maxlength: 11,
                            number: true,
                        },
                        office_code: {
                            required: true,
                            maxlength: 50,
                            remote: {
                                url: base_url+'offices/unique_office_code',
                                type: "post",
                                data: {
                                    office_id: function() {
                                        return $("#hidden_office_id").val();
                                    }
                                }
                            }
                        },
                        office_acronym: {
                            required: true,
                            maxlength: 50,
                            remote: {
                                url: base_url+'offices/unique_office_acronym',
                                type: "post",
                                data: {
                                    office_id: function() {
                                        return $("#hidden_office_id").val();
                                    }
                                }
                            }
                        }
                    },
                
                    // unhighlight: function(element)
                    // {
                    //     $(element).closest('.form-group').removeClass('has-error');
                    // },

                    errorPlacement: function (error, element) {
                        $(element).closest('.form-group').find('.error-message').html(error);
                    },

                    submitHandler: function() {
                        $.ajax({
                            url: base_url + 'offices/validate_office',
                            method: 'POST',
                            data: $('#form_office').serialize(),
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
                                        break;

                                    default:
                                        break;
                                }
                            }
                        });
                    }
                });
            });

            function toggleDeleteAlert( office_id )
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

            function toggle_office( office_id )
            {
                $('#hidden_office_id').val('0');
                $('#action').val("insert");
                $('#office_desc').val('');
                $('#office_code').val('');
                $('#office_rank').val('');
                $('#office_parent').val('').trigger('change');
                $('#office_ppmp').val(1).trigger('change');
                $('#office_acronym').val('');

                if( office_id )
                {
                    $.ajax({
                        url: base_url + 'offices/load_office',
                        method: 'POST',
                        data: {office_id: office_id},
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
                                $('#hidden_office_id').val( office_id );
                                $('#office_desc').val( response[0]['DESCRIPTION'] );
                                $('#office_parent').val( response[0]['PARENT'] ).trigger('change');
                                $('#office_ppmp').val( response[0]['HAS_PPMP'] ).trigger('change');
                                $('#office_code').val( response[0]['CODE'] );
                                $('#office_rank').val( response[0]['RANK'] );
                                $('#office_acronym').val( response[0]['ACRONYM'] );
                            }
                        }
                    });
                }
                
                $('#hidden_office_button').click();
            }
