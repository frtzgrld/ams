
	$(document).ready(function() {

		load_bidder_acceptable_dynamic( lot_id );
		
		$("#form_bid_notice_of_award").validate({
			ignore:'',
			rules: {
				hidden_matrix_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				hidden_award: {
					required: true,
					maxlength: 1,
					number: true,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				var formData = $('#form_bid_notice_of_award').serialize();

				$.ajax({
					url: base_url + 'procurement/bidding/save_bid_award',
					method: 'POST',
					data: formData,
					cache: false,
					dataType: 'json',
					error: function(response)
					{
						alert('error');
					},
					success: function(response)
					{
						$('#modal_award').modal('hide');

						switch( response['result'] )
						{
							case 'success':
								setTimeout(function(){
									swal(response['header'], response['message'], "success");
									load_bidder_acceptable_dynamic( lot_id );
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

	function load_bidder_acceptable_dynamic( lot_id )
	{
		$('#tbody_load_bidder_acceptable').load( base_url + 'procurement/bidding/load_bidder_acceptable/' + lot_id );
	}

	function toggle_bidder_award( matrix_id, awarded )
	{
		$('#form_bid_notice_of_award').trigger("reset");

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
					$('#hidden_award').val( awarded );

					if( awarded )
					{
						$('#yes_btn').addClass('btn-success');
						$('#yes_btn').removeClass('btn-danger');
						$('#form_bid_notice_of_award h3>small').html('Are you sure you want to advance this bidder to Notice of Award?');
					}
					else
					{
						$('#yes_btn').addClass('btn-danger');
						$('#yes_btn').removeClass('btn-success');
						$('#form_bid_notice_of_award h3>small').html('Are you sure you want to cancel the award granted to this bidder?');
					}

					$('#bidder_name').html( response[0]['BIDDER'] );
				}
			}
		});

		$('#modal_award').modal('show');
	}