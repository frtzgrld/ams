
<!-- <pre><?php print_r($quotation); ?></pre> -->
			<form method="post" id="form_quotation" action="" role="form" class="form-horizontal">
	            <input type="hidden" name="hidden_quotation_id" id="hidden_quotation_id" value="<?php echo $quotation?$quotation[0]['ID']:0;?>">
	            <input type="hidden" name="hidden_return_address" id="hidden_return_address" value="<?php echo $this->input->get('return'); ?>">
	            <input type="hidden" name="hidden_action" id="hidden_action" value="<?php echo $quotation?'upadte':'insert';?>">
                <div class="panel">
                	 <header class="panel-heading m-b-0">
	                    <label>RFQ FORM</label>
	                </header>
	                <hr class="m-t-0 m-b-0">
					<div class="panel-body">
			            <div class="form-group">
			                <label class="col-sm-3 control-label-left" for="rq_quot_no">Quotation No.: <span class="text-danger"></span></label>
			                <div class="col-sm-6">
			                    <input type="text" name="rq_quot_no" id="rq_quot_no" class="form-control" autocomplete="off" value="<?php echo $quotation?$quotation[0]['QUOTATION_NO']:NULL;?>">
			                </div>
			                <div class="col-sm-3 error-message"></div>
			            </div>

			            <div class="form-group">
			                <label class="col-sm-3 control-label-left" for="rq_pr_no">Purchase Request No.: <span class="text-danger"></span></label>
			                <div class="col-sm-6">
		                    	<select name="rq_pr_no" id="rq_pr_no" class="select2 form-control"><?php

		                    	$sel_pr = $quotation ? $quotation[0]['PURCHASE_REQUESTS'][0]['ID'] : NULL; 
	                    		if( $purch_req )
	                    			foreach ($purch_req as $pr) {
	                    				$selected = ($sel_pr==$pr['ID']) ? 'selected' : NULL;
	                    				echo '<option '.$selected.' value="'.$pr['ID'].'">'.$pr['PURCHASE_REQUESTS'].'</option>';
	                    			} ?>
		                    		
		                    	</select>
			                </div>
			                <div class="col-sm-3 error-message"></div>
			            </div>

			            <div class="form-group">
			                <label class="col-sm-3 control-label-left" for="rq_canvas_no">Canvas No.: <span class="text-danger"></span></label>
			                <div class="col-sm-6">
			                    <input type="text" name="rq_canvas_no" id="rq_canvas_no" class="form-control" autocomplete="off" value="<?php echo $quotation?$quotation[0]['CANVAS_NO']:NULL;?>">
			                </div>
			                <div class="col-sm-3 error-message"></div>
			            </div>

			            <div class="form-group">
			                <label class="col-sm-3 control-label-left" for="rq_date">Date: <span class="text-danger"></span></label>
			                <div class="col-sm-6">
		                        <input type="text" class="form-control datepicker-autoclose" placeholder="mm/dd/yyyy" id="rq_date" name="rq_date" autocomplete="off" value="<?php echo $quotation?date_format(date_create($quotation[0]['DATEPOSTED']),'m/d/Y'):NULL;?>">
			                </div>
			                <div class="col-sm-3 error-message"></div>
			            </div>

			            <div class="form-group">
			                <label class="col-sm-3 control-label-left" for="rq_authority">Authority: <span class="text-danger"></span></label>
			                <div class="col-sm-6">
			                	<select class="form-control select2" name="rq_authority" id="rq_authority"><?php

			               	$authority = $quotation ? $quotation[0]['AUTHORITY'][0]['ID'] : NULL; 
		                    if( procurement_modes() )
		                    	foreach (procurement_modes() as $modes)
		                    	{	
		                    		$selected = ($authority==$modes['ID']) ? 'selected' : NULL; ?>

	                            	<option <?php echo $selected; ?> value="<?php echo $modes['ID'].'%2D'.$modes['PROCEDURAL'].'%2D'.$modes['ACRONYM'];?>"><?php echo $modes['DESCRIPTION']; ?></option><?php

		                        }	?>
			                    </select>
			                </div>
			                <div class="col-sm-3 error-message"></div>
			            </div>

			            <div class="form-group">
			                <label class="col-sm-3 control-label-left" for="rq_auth_no">Authority No./ Date: <span class="text-danger"></span></label>
			                <div class="col-sm-3">
			                    <input type="text" name="rq_auth_no" id="rq_auth_no" class="form-control" autocomplete="off" value="<?php echo $quotation?$quotation[0]['AUTHORITY_NO']:NULL;?>">
			                </div>
			                <div class="col-sm-3">
			                    <input type="text" class="form-control datepicker-autoclose" placeholder="mm/dd/yyyy" id="rq_auth_date" name="rq_auth_date" autocomplete="off" value="<?php echo $quotation?date_format(date_create($quotation[0]['AUTHORITY_DATE']),'m/d/Y'):NULL;?>">
			                </div>
			                <div class="col-sm-3 error-message"></div>
			            </div>

			            <div class="form-group">
			                <label class="col-sm-3 control-label-left" for="rq_deadline">Deadline of Submission: <span class="text-danger"></span></label>
			                <div class="col-sm-6">
		                        <input type="text" class="form-control datepicker-autoclose" placeholder="mm/dd/yyyy" id="rq_deadline" name="rq_deadline" autocomplete="off" value="<?php echo $quotation?date_format(date_create($quotation[0]['DEADLINE_OF_SUBMISSION']),'m/d/Y'):NULL;?>">
			                </div>
			                <div class="col-sm-3 error-message"></div>
			            </div>
			        </div>
			        <div class="panel-footer">
			            <div class="form-group">
		                    <div class="col-md-2 col-md-offset-7">
		                        <button type="button" class="btn btn-block btn-default waves-effect" data-dismiss="modal" onclick="previousPage()">Back</button>
		                    </div>
		                    <div class="col-md-3">
		                        <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_quotation').submit() );">Save</button>
		                    </div>
			            </div>
			        </div>
			    </div>
        	</form>

	    	<script src="<?php echo base_url(); ?>assets/js/eis/form_quotation.js"></script>
