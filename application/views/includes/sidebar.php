
            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <!-- <div style="margin: 20px;">
                        <div class="row">
                            <div class="col-xs-4">
                                <img src="<?php echo base_url(); ?>assets/images/users/noprofile.png" alt="image" class="img-responsive img-circle" style="width:100%; border: 2px solid #45b0e2">
                            </div>
                            <div class="col-xs-8">
                                <h4 class="text-info m-t-10">
                                    <?php echo $this->session->userdata('FULLNAME'); ?><br>
                                    <small style="color: #797979;"><?php echo $this->session->userdata('EMPLOYEENO'); ?></small>
                                </h4>
                            </div>
                        </div>
                    </div>
 -->
                    <div id="sidebar-menu" style="border-top: 1px solid #3a4b56">
                        <ul>
                        	<li class="text-muted menu-title">Navigation</li>

                            <li class="has_sub">
                                <a href="<?php echo base_url();?>" class="waves-effect <?php if($menu=='dashboard') echo 'active'; ?>"><i class="zmdi zmdi-desktop-windows"></i> <span> Dashboard </span> </a>
                            </li><?php

                            if( has_access('RSYST') ): ?>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect <?php if($menu=='setup') echo 'active subdrop'; ?>"><i class="zmdi zmdi-settings"></i> <span> System Setup </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li class="<?php if($submenu=='items') echo 'active'; ?>"><a class="<?php if($submenu=='items') echo 'active'; ?>" href="<?php echo base_url(); ?>items/">Items</a></li>
                                    <li class="<?php if($submenu=='offices') echo 'active'; ?>"><a href="<?php echo base_url(); ?>offices">Department </a></li>
                                </ul>
                            </li><?php

                            endif;
                            if( has_access('RUSER') ): ?>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect <?php if($menu=='accounts') echo 'active subdrop'; ?>"><i class="zmdi zmdi-accounts"></i> <span> Account Management </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li class="<?php if($submenu=='users') echo 'active'; ?>"><a class="<?php if($submenu=='users') echo 'active'; ?>" href="<?php echo base_url(); ?>account/users/">User Accounts</a></li>
                                </ul>
                            </li><?php

                            endif;
                            
                            if( has_access('RUSER') ): ?>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect <?php if($menu=='inventory') echo 'subdrop'; ?>"><i class="ti ti-bookmark-alt"></i> <span> Inventory </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled" <?php echo ($menu=="inventory")?'style="display: block;"':'style="display: none;"';  ?>><?php
                                    if( has_access('RPEEQ') ): ?>

                                    <li <?php if($submenu=='prop_equip') echo 'class="active"'; ?>>
                                        <a href="<?php echo base_url();?>properties_and_equipment/" <?php if($submenu=='prop_equip') echo 'class="active"'; ?>><span> Properties &amp; Equipments </span></a>
                                    </li><?php

                                    endif;
                                    if( has_access('RSUP') ): ?>

                                    <li <?php if($submenu=='supplies') echo 'class="active"'; ?>>
                                        <a href="<?php echo base_url();?>supplies/" <?php if($submenu=='supplies') echo 'class="active"'; ?>><span> Supplies </span></a>
                                    </li><?php

                                    endif; ?>

                                </ul>
                            </li><?php /*

                            endif;
                            if( has_access('RDISB') ): ?>

                            <li class="has_sub">
                                <a href="<?php echo base_url();?>" class="waves-effect"><i class="ti ti-receipt"></i> <span> Disbursement Voucher </span> </a>
                            </li><?php */

                            endif;
                            if( has_access('RUSER') ): ?>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect <?php if($menu=='file') echo 'active subdrop'; ?>"><i class="ti ti-files"></i> <span> File </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled" <?php echo ($menu=="file")?'style="display: block;"':'style="display: none;"';  ?>>

                                   

                                    <li <?php if($submenu=='ris') echo 'class="active"'; ?>>
                                        <a href="<?php echo base_url();?>file/ris" <?php if($submenu=='ris') echo 'class="active"'; ?>><span> RIS </span></a>
                                    </li>

                                    <li <?php if($submenu=='par') echo 'class="active"'; ?>>
                                        <a href="<?php echo base_url();?>file/par" <?php if($submenu=='par') echo 'class="active"'; ?>><span> PAR </span></a>
                                    </li>
                                    <li <?php if($submenu=='ics') echo 'class="active"'; ?>>
                                        <a href="<?php echo base_url();?>file/ics" <?php if($submenu=='ics') echo 'class="active"'; ?>><span> ICS </span></a>
                                    </li>
                                </ul>
                            </li>
                            <?php

                            endif; ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
			<!-- Left Sidebar End -->

			<!-- ============================================================== -->
			<!-- Start right Content here -->
			<!-- ============================================================== -->
			<div class="content-page">
				<!-- Start content -->
				<div class="content">
					<div class="container">
                        <div class="row" style="margin-top: -10px; margin-bottom: -10px;">
                            <div class="col-sm-8">
                                <h4 class="page-title"><?php echo $title; ?></h4>
                            </div>
                            <div class="col-sm-4" id="button_placement"><?php

                            if( isset($button) )
                            {
                                echo '<button class="btn btn-block '.$button['type'].'" '.(isset($button['onclick'])?'onclick="'.$button['onclick'].'"':NULL).' type="button">'.$button['text'].'</button>';
                            }   ?>

                            </div>
                        </div>

                        <br>
