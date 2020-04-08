
            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="index.html" class="logo">
                            <!-- <i class="zmdi zmdi-toys icon-c-logo"></i><span>MTRCB <span></span></span> -->
                            
                            <!--<span><img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" style="height: 20px;"></span>-->
                            <!-- <i class="zmdi zmdi-toys icon-c-logo"></i> -->
                            
                            <span>Asset Management<span></span></span>
                        </a>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left waves-effect waves-light" id="click_collapse">
                                    <i class="zmdi zmdi-menu"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>

                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li>
                                    <!-- Notification -->
                                    <div class="notification-box">
                                        <ul class="list-inline m-b-0">
                                            
                                        </ul>
                                    </div>
                                    <!-- End Notification bar -->
                                </li>

                                <li class="dropdown user-box" style="width: 260px">
                                    <a href="#" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown" aria-expanded="true">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <img src="<?php echo base_url(); ?>assets/images/users/noprofile.png" alt="user-img" class="img-circle user-img">
                                                <div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
                                            </div>
                                            <div class="col-xs-9" >
                                                <h5 class="text-left m-t-15" style="color: #fefefe">
                                                    <?php echo $this->session->userdata('FULLNAME'); ?><br>
                                                    <small style="color: #fefefe;"><?php echo $this->session->userdata('EMPLOYEENO'); ?></small>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0)"><i class="ti-user m-r-5"></i> Profile</a></li>
                                        <li><a href="javascript:void(0)"><i class="ti-settings m-r-5"></i> Settings</a></li>
                                        <li><a href="javascript:void(0)"><i class="ti-lock m-r-5"></i> Lock screen</a></li>
                                        <li><a href="<?php echo base_url(); ?>login"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->

            <?php
            if( isset($collapse) )
            {
                if( $collapse )
                    echo "<script> $(document).ready(function(){ $('#click_collapse').click(); }); </script>";
            }   ?>