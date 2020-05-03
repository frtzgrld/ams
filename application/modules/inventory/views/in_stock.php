
<!-- <pre><?php print_r($received); ?></pre> -->
<?php
    if( $received ): ?>
    
            <form method="post" id="form_receive" action="" role="form" class="form-horizontal">
                <input type="hidden" name="hidden_stock_id" id="hidden_stock_id" value="0">
                <input type="hidden" name="hidden_action" id="hidden_action" value="insert">
                <div class="panel">
                    <header class="panel-heading">
                        <label>RECEIVE PROPERTY FORM</label>
                    </header>
                    <hr class="m-t-0 m-b-0">
                    <div class="panel-body"><?php

                    foreach ($received[0]['ORDERED_ITEMS'] as $item): ?>

                        <input type="hidden" name="hidden_order_item_id[]" value="<?php echo $item['ID']; ?>">
                        <input type="hidden" name="hidden_supplier_id_<?php echo $item['ID'];?>" value="<?php echo $received[0]['SUPPLIERID']; ?>">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">Item Description</label>
                                    <div class="col-sm-12">
                                        <select class="form-control select2" name="item_<?php echo $item['ID'];?>" id="item">
                                            <option selected value="<?php echo $item['ITEM'][0]['ID'];?>"><?php echo $item['ITEM'][0]['CODE'].': '.$item['ITEM'][0]['DESCRIPTION'];?></option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="item_category">Category</label>
                                    <div class="col-sm-12">
                                        <select class="form-control select2" name="item_category_<?php echo $item['ID'];?>" id="item_category"><?php
                                        if( $item['ITEM'][0]['CATEGORY']=='supply' )
                                            echo '<option value="supply">supply</option>';
                                        else
                                            echo '<option value="property">property</option> <option value="plant">plant</option> <option value="equipment">equipment</option>'; ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="dateacquired">Date Acquired</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong datepicker-autoclose" name="dateacquired_<?php echo $item['ID'];?>" id="dateacquired" placeholder="" type="text" value="<?php echo date_format(date_create($received[0]['RECEIVED_DATE']),'m/d/Y'); ?>">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div><?php

                            if( $item['ITEM'][0]['CATEGORY']!=='supply' )
                            {   ?>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="warranty">Warranty</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong" name="warranty_<?php echo $item['ID'];?>" id="warranty" placeholder="Warranty" type="text">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="useful_life">Useful life</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong" name="useful_life_<?php echo $item['ID'];?>" id="useful_life" placeholder="Est. useful life in year" type="text">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div><?php

                            }
                            else
                            {   ?>

                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="quantity_<?php echo $item['ID'];?>">Quantity</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong" name="quantity_<?php echo $item['ID'];?>" id="quantity" placeholder="Quantity" type="text" value="<?php echo $item['QTY']; ?>">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div><?php

                            }   ?>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="quantity_<?php echo $item['ID'];?>">Unit Cost:</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong text-right" name="unitcost_<?php echo $item['ID'];?>" id="unitcost" type="text" value="<?php echo $item['UNIT_COST']; ?>" readonly>
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="quantity_<?php echo $item['ID'];?>">Unit:</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="hidden_item_unit_<?php echo $item['ID'];?>" value="<?php echo $item['ITEM'][0]['UNIT']; ?>" readonly>
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                        </div><?php

                        if( $item['ITEM'][0]['CATEGORY']!=='supply' ): ?>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Property No.</th>
                                    <th>Serial No.</th>
                                    <!-- <th>Useful Life</th> -->
                                    <th>Brand/Model</th>
                                </tr>
                            </thead>
                            <tbody><?php

                            for ($q=1; $q <= $item['QTY']; $q++): ?>

                                <tr>
                                    <td>
                                        <?php echo $q; ?>
                                    </td>
                                    <td>
                                        <div class="form-group m-b-0">
                                            <div class="col-sm-12">
                                                <input class="form-control text-strong" name="propertyno_<?php echo $item['ID'];?>[]" id="propertyno" placeholder="Property no." type="text">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-b-0">
                                            <div class="col-sm-12">
                                                <input class="form-control text-strong" name="serialno_<?php echo $item['ID'];?>[]" id="serialno" placeholder="Serial no." type="text">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-b-0">
                                            <div class="col-sm-12">
                                                <input class="form-control text-strong" name="brand_<?php echo $item['ID'];?>[]" id="brand" placeholder="brand/model" type="text">
                                            </div>
                                            <!-- <div class="col-sm-12 error-message"></div> -->
                                        </div>
                                    </td>
                                </tr><?php

                            endfor; ?>

                            </tbody>
                        </table>
                        <br><?php

                        endif; // end of if( $item['ITEM'][0]['CATEGORY']=='supply' ) ?>
                        <hr/><?php

                    endforeach; ?>

                        <hr>
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="reset" class="btn btn-block btn-default waves-effect">Reset</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_receive').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form><?php

        endif; ?>
            
            <script src="<?php echo base_url(); ?>assets/js/ams/form_receive.js"></script>
