
	$(document).ready(function() {

		addRow(1);

		$("#form_receive_supply").validate({
			ignore:'',
			rules: {
				hidden_supply_id: {
					required: true,
					maxlength: 11,
				},
				hidden_action: {
					required: true,
					maxlength: 10,
				},
				item: {
					required: true,
					maxlength: 11,
				},
				unitcost: {
					required: true,
					maxlength: 30,
				},
				quantity: {
					required: true,
					maxlength: 30,
				},
				dateacquired: {
					required: true,
					maxlength: 30,
				},
				supplier: {
					required: false,
					maxlength: 250,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'inventory/supplies/validate_received_supplies',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_receive_supply").serialize(),
					error: function(response)
					{
						// toggleError(response);
						// alert('error');
					},
					success: function(response)
					{
						switch( response['result'] )
						{
							case 'success':
								swal(response['header'], response['message'], "success");
								setTimeout(function() {
									if( response['redirect'] )
										window.location.href = response['redirect'];
									else
										window.location.reload();
								}, 	1000);
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


	function addRow( ctr )
	{
		next_ctr = ctr + 1;

		$('#tbody_supply').append(
			'<tr id="row_' + ctr + '">' +
	            '<td>' +
	                '<div class="form-group">' +
	                    '<div class="col-sm-12">' +
	                        '<select class="form-control select2" name="item[]" id="item_' + ctr + '"></select>' +
	                    '</div>' +
	                '</div>' +
	            '</td>' +
	            '<td>' +
	                '<div class="form-group">' +
	                    '<div class="col-sm-12">' +
	                        '<input class="form-control text-strong" name="unitcost[]" id="unitcost_' + ctr + '" placeholder="" type="text">' +
	                    '</div>' +
	                '</div>' +
	            '</td>' +
	            '<td>' +
	                '<div class="form-group">' +
	                    '<div class="col-sm-12">' +
	                        '<input class="form-control text-strong" name="quantity[]" id="quantity_' + ctr + '" placeholder="  " type="text">' +
	                    '</div>' +
	                '</div>' +
	            '</td>' +
	            '<td>' +
	                '<button class="btn btn-block btn-danger btn-trans" type="button" onclick="deleteRow(' + ctr + ')">' +
	                    '<i class="fa fa-trash"></i>' +
	                '</button>' +
	            '</td>' +
	        '</tr>');

		$('#item_' + ctr).select2();

		$.ajax({
            url: base_url + 'items/get_items',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {category: 'supply', leafonly: true},
            async: true,
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                if(response.length == 0) {
                    $('#item_'+ctr).html("No record found");
                } else {
                    $('#item_'+ctr).empty();
                    $.each(response, function(index, value){
                        $('#item_'+ctr)
                            .append($("<option></option>")
                            .attr("value",response[index]['ID'])
                            .text(response[index]['DESCRIPTION'])); 
                    });
                }
            }
        });

        $('#btn_add_row').attr('onclick', 'addRow('+(next_ctr)+')')
	}

	function deleteRow( ctr )
	{
		$('#row_'+ctr).remove();
	}