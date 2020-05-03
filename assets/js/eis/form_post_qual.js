
	$(document).ready(function() {

		load_bidder_evaluation_dynamic( lot_id );
		
		$("#form_post_qual").validate({
			ignore:'',
			rules: {
				hidden_matrix_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				req_status: {
					required: true,
					maxlength: 30,
	                // remote: {
	                //     url: base_url+'procurement/check_remaining_candidate',
	                //     type: "post",
	                //     data: {
	                //         lot_id: function() {
	                //             return lot_id;
	                //         }
	                //     }
	                // }
				},
				req_remark: {
					required: true,
					maxlength: 5000,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				var formData = $('#form_post_qual').serialize();

				$.ajax({
					url: base_url + 'procurement/bidding/update_post_qualification',
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
		$('#tbody_load_bidder_evaluation').load( base_url + 'procurement/bidding/load_bidder_post_qual/' + lot_id );
	}

	function toggle_bidder_evaluation( matrix_id )
	{
		$('#form_post_qual').trigger("reset");

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

	function reminder()
	{
		$.ajax({
			url: base_url + 'procurement/check_remaining_candidate',
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
				if( $('#req_status').val() == 'FORFEITED' )
				{
					if( response )
					{		
						proceed_bidder_evaluation( matrix_id )
					}
					else
					{
				        swal({
				            title: "This is the last eligible candidate. Do you still want to forfeit this last one?",
				            text: "This action is irreversible, and will result to the ...",
				            type: "error",
				            showCancelButton: true,
				            confirmButtonClass: 'btn-danger waves-effect waves-light',
				            confirmButtonText: 'Yes!'
				        });
				        // function (isConfirm) {
				        //     if(isConfirm){
				                
				        //     }
				        // });
					}
				}
			}
		});
	}