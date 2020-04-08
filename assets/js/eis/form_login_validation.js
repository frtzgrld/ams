
	$().ready(function() {

		var loginbtn = $('#btn_login'),
			progress = $('#progress_load'),
			msgalert = $('#response');

		$("#form_login").validate({
			rules: {
				username: {
					required: true,
					minlength: 5,
				},
				password: {
					required: true,
					minlength: 5,
				},
			},

			messages: {
				username: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 5 characters"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
				// $(element).closest('.form-group').find('.form-control').attr('placeholder',error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'account/validate_form_login',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_login").serialize(),
					error: function(response)
					{
						toggleError(response);
					},
					success: function(response)
					{
						loginbtn.hide();
						progress.show();
						msgalert.hide();

						switch( response['login_status'] ) 
						{
							case 'incorrect':
							case 'invalid':
								msgalert.html(
									'<div class="col-xs-12">' +
		                                '<div class="alert alert-danger">' +
		                                    '<strong><i class="ti-face-sad"></i></strong> Incorrect username or password' +
		                                '</div>' +
		                            '</div>');
								chain_reaction(1,0,1);
								break;
							
							case 'success':
								msgalert.html(
									'<div class="col-xs-12">' +
		                                '<div class="alert alert-success">' +
		                                    '<strong>' +
		                                    	'<img src="' + base_url + 'assets/images/loaders/simple_loader.gif" width="20px">' +
		                                    '</strong> Redirecting to your dashboard' +
		                                '</div>' +
		                            '</div>');
								chain_reaction(0,0,1);

								setTimeout(function() {
									window.location.href = base_url + 'home';
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

		function chain_reaction( state_1, state_2, state_3 )
		{
			setTimeout(function(){
				if( state_1 ) loginbtn.show(); else loginbtn.hide();
			},	1000);

			setTimeout(function(){
				if( state_2 ) progress.show(); else progress.hide();
			},	1000);

			setTimeout(function(){
				if( state_3 ) msgalert.show(); else msgalert.hide();
			},	1000);
		}
	});