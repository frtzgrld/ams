                $(document).ready(function() {

                    loadPurchaseOrders();

                    $("#form_receive").validate({
                        ignore:'',
                        rules: {
                            hidden_delivery_id: {
                                required: true,
                                maxlength: 11,
                                number: true,
                            },
                            hidden_action: {
                                required: true,
                                maxlength: 10,
                            },
                            purchase_order: {
                                required: true,
                                maxlength: 30,
                            },
                            hidden_supplier_id: {
                                required: true,
                                maxlength: 11,
                                number: true,
                            },
                            receivedby: {
                                required: true,
                                maxlength: 30,
                            },
                            received_date: {
                                required: true,
                                maxlength: 30,
                            },
                            delivery_note: {
                                required: false,
                            },
                        },

                        errorPlacement: function (error, element) {
                            $(element).closest('.form-group').find('.error-message').html(error);
                        },

                        submitHandler: function() {
                            $.ajax({
                                url: base_url + 'delivery/validate_received_items',
                                method: 'POST',
                                dataType: 'json',
                                async: true,
                                data: $("#form_receive").serialize(),
                                error: function(response)
                                {
                                    alert('error');
                                },
                                success: function(response)
                                {
                                    switch( response['result'] )
                                    {
                                        case 'success':
                                            swal(response['header'], response['message'], 'success');
                                            setTimeout(function() {
                                                if( response['redirect'] != null )
                                                    window.location.href = response['redirect'];
                                            },  2000);
                                            break;

                                        default:
                                            // financerLogin.resetProgressBar(true);
                                            break;
                                    }
                                }
                            });
                        }
                    });
                });

                function loadPurchaseOrders()
                {
                    $.ajax({
                        url: base_url + 'purchase_order/select_purchase_orders',
                        method: 'POST',
                        dataType: 'json',
                        async: true,
                        error: function(response)
                        {
                            alert('error');
                        },
                        success: function(response)
                        {
                            if(response.length == 0) {
                                $('#purchase_order').html("No record found");
                            } else {
                                $('#purchase_order').html('<option selected disabled></option>');
                                $.each(response, function(index, value){
                                    $('#purchase_order')
                                        .append($("<option></option>")
                                        .attr("value",response[index]['ID'])
                                        .text(response[index]['PO_NO']+' - '+response[index]['SUPPLIER'])); 
                                });
                            }
                        }
                    });
                }

                function loadDataPurchaseOrder()
                {
                    $('#ordered_item_list').html('');
                    $('#hidden_supplier_id').val('0');
                    $('#supplier').val('');

                    $.ajax({
                        url: base_url + 'purchase_order/get_purchase_order_detail',
                        method: 'POST',
                        dataType: 'json',
                        async: true,
                        data: {po_id: $('#purchase_order').val()},
                        error: function(response)
                        {
                            alert('error');
                        },
                        success: function(response)
                        {
                            $('#hidden_supplier_id').val(response[0]['SUPPLIERID']);
                            $('#supplier').val(response[0]['SUPPLIER']);

                            var total_cost = 0;

                            for (var i = 0; i < response[0]['ORDERED_ITEMS'].length; i++) 
                            {
                                addOrderedItemRow( i );
                                $.each(response, function(index, value){
                                    $('#delivery_items_'+i)
                                        .append($("<option></option>")
                                        .attr("value",response[0]['ORDERED_ITEMS'][i]['ID'])
                                        .text(response[0]['ORDERED_ITEMS'][i]['DESCRIPTION'])); 
                                });
                                $('#delivery_items_'+i).val(response[0]['ORDERED_ITEMS'][i]['DESCRIPTION']);

                                amount = response[0]['ORDERED_ITEMS'][i]['QTY']*response[0]['ORDERED_ITEMS'][i]['UNIT_COST'];
                                $('#item_qty_'+i).val(response[0]['ORDERED_ITEMS'][i]['QTY']);
                                $('#unit_'+i).val(response[0]['ORDERED_ITEMS'][i]['UNIT']);
                                $('#total_amount_'+i).val(amount);

                                total_cost += amount;
                                $('#total_cost').html(add_commas(parseFloat(total_cost).toFixed(2)));
                            }
                        }
                    });
                }

                function addOrderedItemRow( row_ctr )
                {
                    $('#ordered_item_list').append(
                            '<tr id="row_'+row_ctr+'">' +
                                '<td class="text-center" style="vertical-align:middle">' + (row_ctr+1) + '</td>' +
                                
                                '<td>' +
                                    '<input class="form-control text-strong text-right" name="unit[]" id="unit_'+row_ctr+'" type="text" readonly="readonly">' +
                                '</td>' +
                                '<td>' +
                                    '<select class="form-control select2" name="delivery_items[]" id="delivery_items_'+row_ctr+'"></select>' +
                                '</td>' +
                                '<td>' +
                                    '<input class="form-control text-strong text-right" name="item_qty[]" id="item_qty_'+row_ctr+'" type="text" onkeyup="changeTotalAmount('+row_ctr+')">' +
                                '</td>' +
                                '<td>' +
                                '</td>' +
                            '</tr>'
                        );

                    $('#delivery_items_'+row_ctr).select2();
                    row_ctr = row_ctr + 1;
                    $('#btn_add_row').attr('onclick', 'addOrderedItemRow('+row_ctr+')');
                    $('#total_items').html(row_ctr);
                }

                function changeTotalAmount(row_ctr)
                {
                    var qty = $('#item_qty_'+row_ctr).val(),
                        unit_cost = $('#unit_cost_'+row_ctr).val();
                    
                    $('#total_amount_'+row_ctr).val(qty*unit_cost);
                }