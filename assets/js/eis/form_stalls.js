
	$(document).ready(function() {

		loadStallList();

		$("#form_stalls").validate({
			ignore:'',
			rules: {
				hidden_sec_stall_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				div_sec_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				division: {
					required: true,
					maxlength: 11,
					number: true,
				},
				section: {
					required: true,
					maxlength: 11,
					number: true,
				},
				action: {
					required: true,
					maxlength: 10,
				},
				stall_no: {
					required: true,
					maxlength: 30,
	                remote: {
	                    url: base_url+'enterprise/stall_management/unique_section_stall_number',
	                    type: "post",
	                    data: {
	                        hidden_sec_stall_id: function() {
	                            return $("#hidden_sec_stall_id").val();
	                        },
	                        div_sec_id: function() {
	                        	return $('#div_sec_id').val();
	                        }
	                    }
	                }
				},
				area: {
					required: true,
					maxlength: 11,
					number: true,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'enterprise/stall_management/validate_stall',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_stalls").serialize(),
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
								$('#form_stalls').trigger('reset');
								swal(response['header'], response['message'], "success");
								setTimeout(function() {
									loadStallList();
								}, 	1000);
								break;

							case 'error':
								swal(response['header'], response['message'], "error");
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


	function loadStallList( stall_id=null )
	{
		var tbody_section_stalls = $('#tbody_section_stalls');

		$.ajax({
			url: base_url + 'enterprise/stall_management/stall_list',
			method: 'POST',
			dataType: 'json',
			async: true,
			data: { 'division': division, 'section': section, 'stall': stall_id, 'vacancy': 'all' },
			error: function(response)
			{
				alert('error');
			},
			success: function(response)
			{
				if( stall_id )
				{
					if( response && response.constructor === Array )
					{
						$('#hidden_sec_stall_id').val( response[0]['SECTION_STALL_ID'] );
						$('#div_sec_id').val( response[0]['DIVISION_SECTION'] );
						$('#action').val( 'update' );
						$('#stall_no').val( response[0]['STALL_NO'] );
						$('#area').val( response[0]['AREA'] );						
					}
					else
					{
						alert('NO RECORD FOUND');
					}
				}
				else
				{
					tbody_section_stalls.empty();

					if( response && response.constructor === Array )
					{
						for (var i = 0; i < response.length; i++) 
						{
							tbody_section_stalls.append(
									'<tr>' +
										'<td style="text-indent: 15px">' + response[i]['STALL_NO'] + '</td>' +
										'<td class="text-right">' + add_commas(parseFloat(response[i]['AREA']).toFixed(2)) + ' sq. m.</td>' +
										'<td style="text-indent: 15px">' + 
											((response[i]['CONCESSIONAIRE']==null) ? '' : response[i]['CONCESSIONAIRE']) + 
										'</td>' +
										'<td>' +
											'<button type="button" class="btn btn-block btn-success btn-trans btn-xs" ' +
												'onclick="loadStallList(' + response[i]['SECTION_STALL_ID'] + ')">Edit</button>' +
										'</td>' +
									'</tr>'
								);
						}
					}
					else
					{
						tbody_section_stalls.append(
								'<tr>' +
									'<td colspan="4" class="text-center">Currently no stalls recorded</td>' +
								'</tr>'
							);
					}
				}
			}
		});
	}