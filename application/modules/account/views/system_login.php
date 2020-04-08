<!DOCTYPE html>
<html>
    
<!-- Mirrored from coderthemes.com/flacto_1.5/blue_1_dark/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Feb 2017 15:49:26 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

        <!-- App title -->
        <title>PS</title>

        <!-- App CSS -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
        <script type="text/javascript">
            var base_url = '<?php echo base_url();?>';
        </script>
    </head>
    <body>

        <div class="text-center m-t-15" >
            <a href="index.html" class="logo">
                
            </a>
            <h5 class="text-muted m-t-0">Asset Management System</h5>
        </div>

        <div class="wrapper-page">

        	<div class="m-t-30 card-box">
                <div class="text-center">
                    <h4 class="text-uppercase font-bold m-b-0">Sign In</h4>
                </div>
                <div class="panel-body">
                    <form id="form_login" class="form-horizontal m-t-10" action="" method="post" role="form">

                        <div class="form-group text-center" id="response" style="display: none;">
                            
                        </div>

						<div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="username" id="username" type="text" required="" placeholder="Username" autocomplete="off" >
                                <label class="control-label error-message"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="password" id="password" type="password" required="" placeholder="Password">
                                <label class="control-label error-message"></label>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-custom">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">
                                        Remember me
                                    </label>
                                </div>

                            </div>
                        </div>

						<div class="form-group text-center m-t-30" id="btn_login" style="display: block;">
                            <div class="col-xs-12">
                                <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light text-uppercase" type="submit">Log In</button>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-30" id="progress_load" style="display: none;">
                            <div class="col-xs-12">
                                <div class="alert alert-success">
                                    <strong><img src="<?php echo base_url();?>assets/images/loaders/simple_loader.gif" width="20px"></strong> Loading...
                                </div>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-12">
                                <a href="page-recoverpw.html" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                            </div>
                        </div>

					</form>

                </div>
            </div>
            <!-- end card-box -->

			<!-- <div class="row">
				<div class="col-sm-12 text-center">
					<p class="text-muted">Don't have an account? <a href="page-register.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>
				</div>
			</div>
 -->
        </div>
        <!-- end wrapper page -->

    	<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/detect.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.app.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/eis/form_login_validation.js"></script>

	</body>

<!-- Mirrored from coderthemes.com/flacto_1.5/blue_1_dark/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Feb 2017 15:49:26 GMT -->
</html>