
	$(document).ready(function() {

		load_bidder_opening_dynamic( lot_id );
		
		$("#form_opening").validate({
			ignore:'',
			rules: {
				hidden_lot_no: {
					required: false,
					maxlength: 30,
				},
				ob_bidder: {
					required: true,
					maxlength: 250,
				},
				ob_amount: {
					required: true,
					maxlength: 11,
					number: true,
				},
				op_attaches: {
					required: false,
					maxlength: 300,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				var formData = $('#form_opening').serialize();

				$.ajax({
					url: base_url + 'procurement/bidding/save_bidder_opening_of_bids',
					method: 'POST',
					data: formData,
					cache: false,
					dataType: 'json',
					async: true,
					// processData: false, // Don't process the files
					// contentType: false, // Set content type to false as jQuery will tell the server its a query string request
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
									load_bidder_opening_dynamic( response['load_index'] );
								},	500 );
								break;

							default:
								break;
						}
					}
				});
			}
		});
	});

	function load_bidder_opening_dynamic( lot_id )
	{
		$('#tbody_load_bidder_opening').load( base_url + 'procurement/bidding/load_bidder_opening/' + lot_id );
	}

	function toggle_bidder( matrix_id )
	{
		// $('#action').val('insert');
		$('#hidden_matrix_id').val(0);
		$('#hidden_supplier_id').val(0);
		$('#ob_bidder').val('');
		$('#ob_amount').val('');

		if( matrix_id )
		{
			$.ajax({
				url: base_url + 'procurement/bidding/load_bidding_matrix',
				method: 'POST',
				data: {matrix_id: matrix_id},
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
						$('#hidden_matrix_id').val( matrix_id );
						// $('#hidden_supplier_id').val( response[0]['SUPPLIER'][0]['ID'] );
						$('#ob_bidder').val( response[0]['BIDDER'] );
						$('#ob_amount').val( response[0]['AMOUNT_OFFERED'] );
					}
				}
			});
		}

		$('#hidden_bidder_button').click();
	}