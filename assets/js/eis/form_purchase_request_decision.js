	
	function validateDecisionValue()
	{
		var decBtn = $('#decBtn');

		switch($('#pr_decision').val())
		{
			case 'WAITING':
				decBtn.addClass('disabled');
				break;

			case 'APPROVED':
			case 'REJECTED':
				decBtn.removeClass('disabled');
				break;
		}
	}

	function confirmApproval()
	{
		var dec = $('#pr_decision').val();

		if( dec != 'WAITING' )
		{
			dec = (dec=='APPROVED') ? 'Approve' : 'Reject';

			swal({
	            title: "You are about to " + dec + " this purchase request. Are you sure?",
	            text: "Note: This action is irreversible!",
	            type: "info",
	            showCancelButton: true,
	            confirmButtonClass: 'btn-info waves-effect waves-light',
	            confirmButtonText: 'YES, ' + dec + ' this.'
	        },
	        function(isConfirm){
	        	if(isConfirm)
	        		jQuery($('#form_pr_decision').submit());
	        });
		}
	}

	$(document).ready(function() {

		$("#form_pr_decision").validate({
			ignore:'',
			rules: {
				hidden_pr_id: {
					required: true,
					maxlength: 10,
					number: true,
				},
				pr_decision: {
					required: true,
					maxlength: 30,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'purchase_requests/validate_purchase_request_decision',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_pr_decision").serialize(),
					error: function(response)
					{
						toggleError(response);
					},
					success: function(response)
					{
						switch( response['result'] )
						{
							case 'success':
								swal(response['header'], response['message'], "success");
								setTimeout(function() {
									// window.location.reload();
								}, 	1500);
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