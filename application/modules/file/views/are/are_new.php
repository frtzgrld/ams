<!-- <pre><?php print_r($this->session->all_userdata()); ?></pre>  -->

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <!-- <p class="header-title m-t-0 m-b-30" align="center">ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</p> -->
            <!-- <hr> -->
            <form id="are_header" action="<?php echo base_url(); ?>file/are/are_header_save" method="post" class="form-horizontal" role="form">

                <div class="form-group">
                    
                    <div class="col-sm-12" align="center">
                    <label class="control-label-center" for="description" style="font-size: 150%; text-decoration: underline">VALENCIA</label><br/>
                    <label class="control-label-center" for="description">Agency</label>
                   
                    </div>
                   
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9" align="right">
                        <label class="control-label-right" align="right">ARE No.<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="right">
                        <input type="text" class="form-control" name="are_no" id="are_no" value="">
                    </div>
                    <div class="col-md-9 col-md-offset-9 error-message"></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9" align="right">
                        <label class="control-label-right" align="right">Date<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="right">
                         <input type="text" class="po_date_pckr form-control" name="date" id="datepicker-autoclose" value="">
                    </div>
                    <div class="col-md-9 col-md-offset-9 error-message"></div>
                </div>

                 <div class="form-group">
                    <label class="col-sm-2 control-label-left" for="description">Office:</label>
                    <div class="col-sm-6">
                    <select name="office" id="office" class="form-control select2" placeholder="Select Office">
                    <option value=""> </option><?php
                    foreach ($offices as $row): ?>
                        <option value="<?php echo $row['ID'];?>"><?php echo $row['DESCRIPTION'];?></option><?php
                    endforeach; ?>
                    </select>

                    </div>
                </div>

              

                <!-- ARE ITEMS-->
                <table class="table table-striped m-0">
            <thead>
                <tr>
                    <th rowspan="1">QTY</th>
                    <th rowspan="1">UNIT</th>
                    <th rowspan="1">ARTICLE DESCRIPTION</th>
                    <th rowspan="1">CLASS CODE</th>
                    <th rowspan="1">DATE ACQUIRED</th>
                    <th rowspan="1">PROPERTY NO</th>
                    <th rowspan="1">UNIT COST</th>
                    <th rowspan="1">TOTAL COST</th>
                    <th rowspan="1">ACTION</th>

                </tr>
                
            </thead>
          
                <tbod>
              <?php 
           if(!empty($are_items_list))
            {
                // echo print_r($items,true);
                foreach ($are_items_list as $key) 
                :?>
                <tr>
                    <td><?php echo $key['SERIALNO']; ?></td>
                    <td><?php echo $key['ARE_NO']; ?></td>
                    <td><?php echo $key['DESCRIPTION']; ?></td>
                    <td><?php echo $key['UNITCOST']; ?></td>
                    <td><?php echo $key['SERIALNO']; ?></td>
                    <td><?php echo $key['ARE_NO']; ?></td>
                    <td><?php echo $key['DESCRIPTION']; ?></td>
                    <td><?php echo $key['UNITCOST']; ?></td>
                    <td> <?php if($key['prop_id'] == null) { echo '<button class="btn btn-primary waves-effect waves-light" onclick="deleteItem('.$key['prop_id'].')" >Add</button>'; } else { echo '<button class="btn btn-primary waves-effect waves-light" onclick="deleteItem('.$key['prop_id'].')" >Delete</button>'; }?> </td>
                </tr>
                <?php endforeach; 
            }
                    ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td> 
                </tbod>
                </table>

                <br/>
                <br/>

                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Serial No.<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="serialno" id="serialno" value="">
                    </div>
                    <!-- <div class="col-md-3 col-md-offset-4 error-message"></div> -->

                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Location No.</label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="location" id="location" value="">
                    </div>
                    <!-- <div class="col-md-8 col-md-offset-4 error-message"></div> -->
                    <div class="col-md-2 col-md-offset-2 error-message"></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Remarks</label>
                    </div>
                    
                    <div class="col-sm-10" for="createdby" align="right">
                        <input type="text" class="form-control" name="serialno" id="serialno" value="">
                    </div>
                </div>
                <br/>

                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-5" align="left">
                        <label class="control-label-left" align="right">Received By</label>
                    </div>
                    
                   <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-5" align="left">
                        <label class="control-label-left" align="right">Receive From</label>
                    </div>
                    
                   
                </div>

                <!-- Received By/From Name -->
                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_by" id="received_by" value="">
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_from" id="received_from" value="">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Signature over Printed Name</label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Signature over Printed Name</label>
                    </div>
                    
                </div>

                <!-- Received By/From Position -->
                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_by_position" id="received_by_position" value="">
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_from_position" value="">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="center">Position/Office</label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Position/Office</label>
                    </div>
                    
                </div>

                <!-- Received Date By/From  -->
                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="po_date_pckr form-control" name="received_by_date" id="received_by_date" value="">
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="po_date_pckr form-control" name="received_from_date" value="">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Date</label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Date</label>
                    </div>
                    
                </div>

                <hr>
                <div class="row">
		            <div class="form-group m-b-0">
		                <div class="col-sm-offset-7 col-sm-4">
		                	<button type="button" onclick="goBack()" class="btn btn-inverse waves-effect w-md waves-light m-b-5">Back to Item List</button>
		                <button type="submit" class="btn btn-primary waves-effect w-md waves-light m-b-5">Save</button>
		                </div>
		            </div>
		        </div>
            </form>
            
        </div>
    </div><!-- end col -->
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/eis/validation_are.js"></script>