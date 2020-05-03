
	$(document).ready(function() {

		loadSections();

		$("#form_concessionaire").validate({
			ignore:'',
			rules: {
				hidden_con_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				hidden_clientno: {
					required: true,
					maxlength: 11,
					number: true,
				},
				action: {
					required: true,
					maxlength: 10,
				},
				con_refno: {
					required: true,
					maxlength: 6,
	                remote: {
	                    url: base_url+'purchase_requests/unique_pr_number',
	                    type: "post",
	                    data: {
	                        hidden_pr_id: function() {
	                            return $("#hidden_pr_id").val();
	                        }
	                    }
	                }
				},
				concessionaire: {
					required: true,
					maxlength: 250,
				},
				concessions: {
					required: true,
					maxlength: 11,
				},
				section: {
					required: true,
					maxlength: 150,
				},
				enterprise_mode: {
					required: false,
					maxlength: 25,
				},
				enterprise_date: {
					required: false,
					maxlength: 30,
				},
				amt_cash_ticket: {
					required: true,
					maxlength: 11,
					number: true,
				},
				amt_daily_rental: {
					required: true,
					maxlength: 11,
					number: true,
				},
				amount: {
					required: true,
					maxlength: 30,
				},
				location: {
					required: true,
					maxlength: 300,
				},
				barangay: {
					required: true,
					maxlength: 11,
				},
				mobileno: {
					required: false,
					maxlength: 30,
				},
				telephone: {
					required: false,
					maxlength: 30,
				},
				email: {
					required: false,
					maxlength: 250,
					email: true
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'enterprise/concessionaires/validate_concessionaire',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_concessionaire").serialize(),
					error: function(response)
					{
						// toggleError(response);
						alert('error');
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

	function toggle_client( enable=1 )
	{
		if( enable )
			$('#hidden_client_button').click();
	}

	function loadSections()
	{
		$.ajax({
			url: base_url + 'enterprise/stall_management/sections_list',
			method: 'POST',
			dataType: 'json',
			async: true,
			data: {'division': $('#division').val()},
			error: function(response)
			{
				// toggleError(response);
				alert('error');
			},
			success: function(response)
			{
				$('#section').html('');
				$('#section').select2('data', {id: null, text: ''});

				if(response.length > 0) {
                    $.each(response, function(index, value){
                        $('#section')
                            .append($("<option></option>")
                            .attr("value",response[index]['ID'])
                            .text(response[index]['SECTION'])); 
                    });
                }
			}
		});
	}

	function loadStalls( vacancy=null )
	{
		$.ajax({
			url: base_url + 'enterprise/stall_management/stall_list',
			method: 'POST',
			dataType: 'json',
			async: true,
			data: {'division': $('#division').val(), 'section': $('#section').val(), 'vacancy': vacancy },
			error: function(response)
			{
				alert('error');
			},
			success: function(response)
			{
				$('#stall_no').html('');
				$('#stall_no').select2('data', {id: null, text: ''});

				if(response.length > 0) {
                    $.each(response, function(index, value){
                        $('#stall_no')
                            .append($("<option></option>")
                            .attr("value",response[index]['SECTION_STALL_ID'])
                            .text(response[index]['STALL_NO'])); 
                    });
                }
			}
		});
	}