<!-- <pre><?php print_r($this->session->all_userdata()); ?></pre>  -->

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <!-- <p class="header-title m-t-0 m-b-30" align="center">ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</p> -->
            <!-- <hr> -->
            <form id="ris_header" action="<?php echo base_url(); ?>file/ris/ris_header_save" method="post" class="form-horizontal" role="form">

                <div class="form-group">
                    
                    <div class="col-sm-12" align="center">
                    <label class="control-label-center" for="description" style="font-size: 150%; text-decoration: underline">REQUISITION & ISSUANCE SLIP</label><br/>
                    <!-- <label class="control-label-center" for="description">Agency</label> -->
                   
                    </div>
                   
                </div>
                
                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="left">Requisition Department:<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        <select name="office" id="office" class="form-control select2" placeholder="Select Office">
                        <option value=""> </option><?php
                        foreach ($offices as $row): ?>
                            <option value="<?php echo $row['ID'];?>"><?php echo $row['DESCRIPTION'];?></option><?php
                        endforeach; ?>
                        </select>
                    </div>
                   
                    
                    
                    
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="left"></label>
                    </div>

                     <div class="col-sm-2" align="right">
                        <label class="control-label-right" align="right">RIS No:<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        <input type="text" class="form-control" name="ris_no" id="ris_no" value="">
                    </div>
                    
                    <!-- <div class="col-sm-3" for="createdby" align="left">
                        <input type="text" class="form-control" name="po_no" id="po_no" value="">
                    </div> -->
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                </div>

                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="left"><span class="text-danger"></span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        
                    </div>
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="left"></label>
                    </div>

                    <div class="col-sm-2" align="right">
                        <label class="control-label-right" align="right">Date:<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        <input class="form-control text-strong datepicker-autoclose" name="requested_date" id="requested_date" type="text" placeholder="" value="">
                    </div>
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                </div>

               
              

                <!-- ARE ITEMS-->
                <table class="table table-striped m-0">
            <thead>
                <tr>
                    <th rowspan="1">STOCK NO.</th>
                    <th rowspan="1">QTY</th>
                    <th rowspan="1">UNIT</th>
                    <th rowspan="1">SIZE</th>
                    <th rowspan="1">DESCRIPTION</th>
                    <th rowspan="1">QTY RELEASED</th>
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

              <!--   <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Purpose</label>
                    </div>
                    
                    <div class="col-sm-10" for="createdby" align="right">
                        <input type="text" class="form-control" name="purpose" id="purpose" value="">
                    </div>
                </div> -->

                <br/>


                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Requested By:</label>
                    </div>
                    
                   
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Noted By:</label>
                    </div>

                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Approved for Release:</label>
                    </div>

                </div>

               

                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <input type="text" class="form-control" name="requested_by" id="requested_by" value="">
                        <br/> Name and Signature
                    </div>
                    
                   
                    <div class="col-sm-2" align="left">
                        <input type="text" class="form-control" name="noted_by" id="noted_by" value="">
                        <br/>
                        Department Head
                    </div>

                    <div class="col-sm-2" align="left">
                    <input type="text" class="form-control" name="approved_by" id="approved_by" value="">
                    <br/>
                    Lanie N. MAcabaya<br/>
                    Supply Officer III
                    </div>

                   
                   
                </div>
                <br/><br/>

                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Released By:</label>
                    </div>
                    
                   
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Received By:</label>
                    </div>

                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Posted by:</label>
                    </div>

                </div>


                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <input type="text" class="form-control" name="issued_by" id="issued_by" value="">
                    </div>
                    
                   
                    <div class="col-sm-2" align="left">
                        <input type="text" class="form-control" name="received_by" id="received_by" value="">
                    </div>

                    <div class="col-sm-2" align="left">
                    <input type="text" class="form-control" name="posted_by" id="posted_by" value="">
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/eis/receiving_management.js"></script>