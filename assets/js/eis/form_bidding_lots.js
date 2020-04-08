
                $(document).ready(function () {

                    $("#form_bidding_lot").validate({
                        ignore:'',
                        rules: {
                            hidden_procurement_id: {
                                required: true,
                                maxlength: 11,
                                number: true,
                            },
                            action: {
                                required: true,
                                maxlength: 6,
                            },
                            lot_number: {
                                required: true,
                                maxlength: 11,
                                number: true,
                            },
                            lot_description: {
                                required: true,
                                maxlength: 250,
                            },
                        },

                        errorPlacement: function (error, element) {
                            $(element).closest('.form-group').find('.error-message').html(error);
                        },

                        submitHandler: function() {
                            $.ajax({
                                url: base_url + 'procurement/bidding/validate_bidding_lot',
                                method: 'POST',
                                data: $('#form_bidding_lot').serialize(),
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
                                            setTimeout(function(){
                                                swal(response['header'], response['message'], "success");
                                            },  500 );
                                            setTimeout(function(){
                                                window.location.reload();
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

                function toggleDeleteLot( lot_id )
                {
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this lot!",
                        type: "error",
                        showCancelButton: true,
                        confirmButtonClass: 'btn-danger waves-effect waves-light',
                        confirmButtonText: 'Delete!'
                    },
                    function(isConfirm){
                        if(isConfirm)
                        {
                            $.ajax({
                                url: base_url + 'procurement/validate_delete_lot',
                                method: 'POST',
                                data: {lot_id: lot_id},
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
                                            window.location.reload();
                                            break;

                                        default:
                                        case 'error':
                                            swal(response['header'], response['message'], "error");
                                            break;
                                    }
                                }
                            });
                        }
                    });
                }

                function toggle_lot( lot_id )
                {
                    //  Reset to default values
                    $('#hidden_procurement_id').val('0');
                    $('#action').val("insert");
                    $('#lot_number').val('');
                    $('#lot_description').val('').trigger('change');

                    if( lot_id )
                    {
                        $.ajax({
                            url: base_url + 'procurement/bidding/get_lot_detail',
                            method: 'POST',
                            data: {lot_id: lot_id},
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
                                    $('#hidden_procurement_id').val( response[0]['PROCUREMENT'] );
                                    $('#lot_description').val( response[0]['DESCRIPTION'] );
                                    $('#lot_number').val( response[0]['LOTNO'] );
                                }
                            }
                        });
                    }
                    
                    $('#hidden_lot_button').click();
                }