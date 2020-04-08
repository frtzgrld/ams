<?php 
    if( $itemdetail )
        foreach ($itemdetail as $row): ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-custom panel-border">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <small class="text-default">DETAIL OF ITEM</small>
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
									<td>Item code:</td>
                                    <td><?php echo $row['CODE']; ?></td>
                                </tr>
                                <tr>
									<td>Unit:</td>
                                    <td><?php echo $row['UNIT']; ?></td>
                                </tr>
                                <tr>
									<td>Category:</td>
                                    <td><?php echo $row['CATEGORY']; ?></td>
                                </tr>
                                <tr>
									<td>Parent:</td>
                                    <td>
                                        <a href="<?php echo base_url().'items/items_detail/'.$row['PARENT']; ?>"><?php echo $row['PARENT_DESC']; ?></a>
                                    </td>
                                </tr>
                                <tr>
									<td>Minimum quantity:</td>
                                    <td><?php echo $row['MINQTY']; ?></td>
                                </tr>
								<tr>
									<td>Maximum quanity:</td>
                                    <td><?php echo $row['MAXQTY']; ?></td>
                                </tr>
								<?php

                                if( isset($row['CHILDREN']) ): ?>

                                <tr>
                                    <td rowspan="<?php if ($row['CHILDREN']) { echo count($row['CHILDREN']); }  ?>">Child items:</td>
                                    <td><?php

                                    if( $row['CHILDREN'] )
                                        foreach ($row['CHILDREN'] as $subitem)
                                            echo '<a href="'.base_url().'items/items_detail/'.$subitem['ITEMID'].'">'.strtolower($subitem['DESCRIPTION']).'</a> / '; ?>
                                    </td>
                                </tr><?php

                                endif; ?>
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
            <div class="card-box widget-user">
				<div>
					
					<div class="wid-u-info" style="margin-left: 80px">
						<h4 class="m-t-0 m-b-5">
							<small>Recorded by:</small>
							<br><?php echo profile('EMPLOYEENO', $row['CREATEDBY'], 'LASTNAME'); ?>
						</h4>
						<p class="text-muted m-b-5 font-13"><?php echo date_format( date_create($row['CREATEDDATE']), 'F d, Y h:i A'); ?></p>
						<small class="text-custom"><b><?php echo profile('EMPLOYEENO', $row['CREATEDBY'], 'DESCRIPTION'); ?></b></small>
					</div>
				</div>
			</div>
        </div><?php
        	endif;

        endforeach; ?>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/eis/item_management.js"></script>





