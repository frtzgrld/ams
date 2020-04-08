<?php 
    if( $detail )
        foreach ($detail as $row): ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-custom panel-border">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <small class="text-default">DETAIL OF</small>
                            <br/><?php echo $row['DESCRIPTION']; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th width="30%"></th>
                                    <th width="70%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Division / Office / Unit code:</td>
                                    <td><?php echo $row['CODE']; ?></td>
                                </tr>
                                <tr>
                                    <td>Division / Office / Unit name:</td>
                                    <td><?php echo $row['DESCRIPTION']; ?></td>
                                </tr>
                                <tr>
                                    <td>Acronym:</td>
                                    <td><?php echo $row['ACRONYM']; ?></td>
                                </tr>
                                <tr>
                                    <td>Under office of:</td>
                                    <td>
                                        <!--a href="<?php echo base_url().'offices/office_detail/'.strtolower($row['CODE']); ?>"--><?php echo $row['PARENT_DESC']; ?><!-- </a> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Can create PPMP:</td>
                                    <td><?php echo $row['HAS_PPMP'] == 1 ? 'Yes' : 'No'; ?></td>
                                </tr>
                            </tbody>
                            <tfoot class="hidden">
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-box">
                    <h5 class="m-t-0">Action</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo base_url('offices');?>" class="btn btn-default btn-block btn-trans waves-effect waves-default m-b-5">Back to office list</a>
                        </div>
                        
                    </div>
                </div>

                
                
            </div>
        </div>

        <hr class="m-t-0"><?php

        if( isset($row['CHILDREN']) )
        	if( $row['CHILDREN'] ) :?>

        <div class="panel panel-custom panel-border">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <small class="text-default">OFFICES / UNITS ATTACHED TO</small>
                    <br/><?php echo $row['DESCRIPTION']; ?>
                </h3>
            </div>
            <div class="panel-body">
            	<table class="table m-0">
                    <thead>
                        <tr>
                            <th width="10%"></th>
                            <th width="60%"></th>
                            <th width="20%"></th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody><?php $ctr = 0;

                        if( $row['CHILDREN'] )
                            foreach ($row['CHILDREN'] as $subitem): $ctr++; ?>

	                    <tr>
	                    	<td><?php echo $ctr; ?></td>
	                    	<td><?php echo $subitem['DESCRIPTION']; ?></td>
	                    	<td><?php echo $subitem['ACRONYM']; ?></td>
	                    	<td>
	                    		<a class="btn btn-block btn-xs btn-info btn-tras" href="<?php echo base_url(); ?>offices/office_detail/<?php echo strtolower($subitem['CODE']); ?>">view</a>
	                    	</td>
	                    </tr><?php
	                    	endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div><?php
        	endif;

        endforeach; ?>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/eis/office_management.js"></script>