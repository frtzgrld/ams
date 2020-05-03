		
<!-- <pre><?php //print_r($quotation); ?></pre> -->
<?php
	if( $quotation )
		foreach ($quotation as $row): ?>

		<div class="row">
            <div class="col-lg-8">
            	<div class="panel panel-custom panel-border">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                        	<small class="text-default">DETAIL OF</small>
                        	<br/>Quotation # <?php echo $row['QUOTATION_NO']; ?>
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
                        			<td>Purchase Request number(s):</td>
                        			<td><?php 
                        				if($row['PURCHASE_REQUESTS']) {
                        					$pr = '';
                        					foreach($row['PURCHASE_REQUESTS'] as $prs)
                        						$pr .= $prs['PR_NO'].'; ';
                        				}	echo $pr;	?>
                        						
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Canvas number:</td>
                        			<td><?php echo $row['CANVAS_NO']; ?></td>
                        		</tr>
                        		<tr>
                        			<td>Date:</td>
                        			<td><?php echo date_format(date_create($row['DATEPOSTED']), 'd F Y'); ?></td>
                        		</tr>
                        		<tr>
                        			<td>Authority:</td>
                        			<td><?php 
                        				if($row['AUTHORITY']) {
                        					foreach($row['AUTHORITY'] as $auth)
                        						echo $auth['DESCRIPTION'];
                        				}	?>
                        					
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Authority number:</td>
                        			<td><?php echo $row['AUTHORITY_NO']; ?></td>
                        		</tr>
                        		<tr>
                        			<td>Authority Date:</td>
                        			<td><?php echo date_format(date_create($row['AUTHORITY_DATE']), 'd F Y'); ?></td>
                        		</tr>
                        		<tr>
                        			<td>Deadline of submission:</td>
                        			<td><?php echo date_format(date_create($row['DEADLINE_OF_SUBMISSION']), 'd F Y'); ?></td>
                        		</tr>
                        		<tr class="hidden">
                        			<td>Status:</td>
                        			<td><?php echo $row['PROCEDURE_STATUS']; ?></td>
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
            	<div class="card-box widget-user">
                    <div>
                        <img src="<?php echo base_url(); ?>assets/images/users/noprofile.png" style="width:60px; height:60px" class="img-responsive img-circle" alt="user">
                        <div class="wid-u-info" style="margin-left: 80px">
                            <h4 class="m-t-0 m-b-5">
                                <small>Recorded by:</small>
                                <br><?php echo profile('EMPLOYEENO', $row['POSTED_BY'], 'FULLNAME'); ?>
                            </h4>
                            <p class="text-muted m-b-5 font-13"><?php echo date_format( date_create($row['DATEPOSTED']), 'F d, Y'); ?></p>
                            <small class="text-custom"><b><?php echo profile('EMPLOYEENO', $row['POSTED_BY'], 'OFFICES'); ?></b></small>
                        </div>
                    </div>
                </div>

                <div class="card-box">
                    <h5 class="m-t-0">Action</h5>
                	<div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo base_url('file/quotations');?>" class="btn btn-default btn-block btn-trans waves-effect waves-default m-b-5">Back to RFQ list</a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo base_url();?>file/quotations/edit_quotation/<?php echo $row['ID']; ?>" class="btn btn-success btn-block btn-trans waves-effect waves-light waves-success m-b-5"><i class="zmdi zmdi-edit""></i></a>
                        </div>
                        <div class="col-md-3">
                            <button type="button" onclick="toggleDeleteRecord(<?php echo $row['ID']; ?>)" class="btn btn-danger btn-block btn-trans waves-effect waves-danger m-b-5"><i class="zmdi zmdi-delete"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="m-t-0"><?php

        if( $row['PURCHASE_REQUESTS'] )
        	foreach( $row['PURCHASE_REQUESTS'] as $prs ): ?>

        <div class="panel panel-custom panel-border">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <small class="text-default">ITEMS' DESCRIPTION</small>
                    <br/>PR # <?php echo $prs['PR_NO']; ?>
                </h3>
            </div>
            <div class="panel-body">
            	<table class="table m-0">
                    <thead>
                    	<tr>
                    		<th colspan="8">Purpose: <?php echo $prs['PURPOSE']; ?></th>
                    	</tr>
                        <tr class="table-ams">
                            <th width="05%">#</th>
                            <th width="20%">Item</th>
                            <th width="10%">Unit</th>
                            <th width="20%">Specification</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Unit Cost</th>
                            <th width="20%">Amount</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody><?php $ctr = $total_amount = 0;

                        foreach ($prs['ITEMS'] as $item): 
                        	$ctr++; ?>

	                    <tr>
	                    	<td><?php echo $ctr; ?></td>
	                    	<td><?php echo $item['PRI_DESC']; ?></td>
	                    	<td class="text-center"><?php echo $item['UNIT']; ?></td>
	                    	<td><pre><?php echo $item['SPECS']; ?></pre></td>
	                    	<td class="text-right"><?php echo number_format($item['QTY'], 0); ?></td>
	                    	<td class="text-right"><?php echo number_format($item['UNIT_COST'], 2); ?></td>
	                    	<td class="text-right"><?php echo 'Php '.number_format($item['AMOUNT'], 2); ?></td>
	                    	<td>
	                    		<!-- <a class="btn btn-block btn-xs btn-info btn-tras" href="<?php echo base_url(); ?>offices/office_detail/<?php echo strtolower($subitem['CODE']); ?>">view</a> -->
	                    	</td>
	                    </tr><?php
	                    	$total_amount += $item['AMOUNT'];
	                    endforeach; ?>

                    </tbody>
                    <tfoot>
                    	<tr>
                    		<td colspan="6">Total amount:</td>
                    		<td class="text-right text-success text-strong"><?php echo 'Php '.number_format($total_amount, 2); ?></td>
                    		<td></td>
                    	</tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <script type="text/javascript">
			$(document).ready(function(){

				var rfq_id = <?php echo $row['ID']; ?>;
				$('#button_placement').html(
						'<button class="btn btn-block btn-info" onclick="jQuery(popup_window(\''+base_url+'file/quotations/print_quotation/' + rfq_id + '\'));"><i class="fa fa-print"></i> PRINT QUOTATION</button>'
					);
			})
		</script><?php
        
        	endforeach;
       	endforeach; ?>
