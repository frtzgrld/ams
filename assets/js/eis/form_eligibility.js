

	$(document).ready(function() {

		load_bidder_pre_bid_dynamic( lot_id );
		
		$("#form_eligibility").validate({
			ignore:'',
			rules: {
				hidden_lot_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				hidden_lot_no: {
					required: true,
					maxlength: 30,
				},
				hidden_matrix_id: {
					required: true,
					maxlength: 250,
				},
				hidden_action: {
					required: true,
					maxlength: 10,
				},
				eligibility: {
					required: true,
					maxlength: 50,
				},
				eligible_remark: {
					required: false,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				var formData = $('#form_eligibility').serialize();

				$.ajax({
					url: base_url + 'procurement/bidding/save_bidder_eligibility',
					method: 'POST',
					data: formData,
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
									load_bidder_pre_bid_dynamic( response['load_index'] );
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

	function load_bidder_pre_bid_dynamic( lot_id )
	{
		$('#tbody_load_bidder_pre_bid').load( base_url + 'procurement/bidding/load_bidder_eligibility_check/' + lot_id );
	}

	function toggle_bidder( matrix_id )
	{
		// alert(matrix_id);
		$('#hidden_action').val('insert');
		$('#hidden_matrix_id').val(0);
		$('#eligibility_remark').val('');
		$('#address').val('');
		$('#contact_person').val('');
		$('#contact_no').val('');
		$('#email').val('');

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
						$('#hidden_action').val('update');
						$('#hidden_matrix_id').val( matrix_id );
						// $('#hidden_supplier_id').val( response[0]['SUPPLIER'][0]['ID'] );
						$('#company_name').html( response[0]['BIDDER'] );
					}
				}
			});
		}

		$('#hidden_bidder_button').click();
	}