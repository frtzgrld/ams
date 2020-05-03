<!-- <pre><?php print_r($this->session->all_userdata()); ?> -->

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <!-- <p class="header-title m-t-0 m-b-30" align="center">ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</p> -->
            <!-- <hr> -->
            <form id="ris_header" action="<?php echo base_url(); ?>file/ics/ics_header_save" method="post" class="form-horizontal" role="form">

                <div class="form-group">
                    
                    <div class="col-sm-12" align="center">
                    <label class="control-label-center" for="description" style="font-size: 150%; text-decoration: underline">CODEV</label><br/>
                    <label class="control-label-center" for="description">Agency</label>
                   
                    </div>
                   
                </div>
                
                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="left">Fund Cluster:<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        <input type="text" class="form-control" name="fund_cluster" id="fund_cluster" value="">
                    </div>
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="left"></label>
                    </div>

                    <div class="col-sm-2" align="right">
                        <label class="control-label-right" align="right">ICS No.<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        <input type="text" class="form-control" name="ics_no" id="ics_no" value="">
                    </div>
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                </div>


                <!-- ARE ITEMS-->
                <table class="table table-striped m-0">
            <thead>
                <tr>
                    <th rowspan="1">QTY.</th>
                    <th rowspan="1">UNIT</th>
                    <th rowspan="1">DESCRIPTION</th>
                    <th rowspan="1">PROPERTY NO.</th>
                    <th rowspan="1">DATE ACQUIRED</th>
                    <th rowspan="1">AMOUNT</th>
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
                </tbod>
                </table>

                <br/>
                <br/>

                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" align="left">
                        <label class="control-label-left" align="right">Received From</label>
                    </div>
                    
                   <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-5" align="left">
                        <label class="control-label-left" align="right">Issued By</label>
                    </div>
                    
                   
                </div>

                <!-- Received By/From Name -->
                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_from" id="received_from" value="">
                    </div>
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="issued_by" id="issued_by" value="">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" align="left">
                        <label class="control-label-left" align="right">Signature over Printed Name</label>
                    </div>
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" align="left">
                        <label class="control-label-left" align="right">Signature over Printed Name</label>
                    </div>
                    
                </div>

                <!-- Received By/From Position -->
                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_from_position" id="received_from_position" value="">
                    </div>
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="issued_by_position" id="issued_by_position" value="">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="center">Position/Office</label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Position/Office</label>
                    </div>
                    
                </div>

                <!-- Received Date By/From  -->
                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="po_date_pckr form-control" name="received_from_date" id="received_from_date" value="">
                    </div>
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="po_date_pckr form-control" name="issued_by_date" id="issued_by_date" value="">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Date</label>
                    </div>
                    <div class="col-sm-2" align="left">
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
