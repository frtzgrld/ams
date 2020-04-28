
	$(document).ready(function() {

		load_bidder_evaluation_dynamic( lot_id );
		
		$("#form_bid_evaluation").validate({
			ignore:'',
			rules: {
				hidden_matrix_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				be_status: {
					required: true,
					maxlength: 30,
				},
				be_remark: {
					required: true,
					maxlength: 5000,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				var formData = $('#form_bid_evaluation').serialize();

				$.ajax({
					url: base_url + 'procurement/bidding/update_bid_evaluation',
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
						$('#select_bidder_modal').modal('hide');

						switch( response['result'] )
						{
							case 'success':
								setTimeout(function(){
									swal(response['header'], response['message'], "success");
									// $('#tbody_load_bidder_opening').load( base_url + 'bidding/load_bidder_opening/' + response['load_index'] );
									load_bidder_evaluation_dynamic( lot_id );
								},	500 );
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

	function load_bidder_evaluation_dynamic( lot_id )
	{
		$('#tbody_load_bidder_evaluation').load( base_url + 'procurement/bidding/load_bidder_evaluation/' + lot_id );
	}

	function toggle_bidder_evaluation( matrix_id )
	{
		$('#form_bid_evaluation').trigger("reset");

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
					$('#hidden_matrix_id').val( matrix_id );
					$('#plot_bidder_name').html( response[0]['BIDDER'] );
					$('#be_status').val( response[0]['STATUS'] );
					$('#be_remark').html( response[0]['REMARK'] );
				}
			}
		});

		$('#select_bidder_modal').modal('show');
	}