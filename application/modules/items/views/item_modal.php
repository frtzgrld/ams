        <div id="item_modal" class="modal door" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:90%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="Custombox.close();">
                            <span>×</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="custom-width-modalLabel">ITEM FORM</h4>
                    </div>

                    <div class="modal-body">
                        <form id="form_item" action="<?php echo base_url(); ?>items/items_create" method="post" class="form-horizontal" role="form">
                            <input type="hidden" name="hidden_item_id" id="hidden_item_id" value="0">
                            <input type="hidden" name="action" id="action" value="insert">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-3 control-label-left" for="category">Category <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <select name="category" id="category" class="form-control select2">
                                            <option value=""></option>
                                            <option value="supply">Supply</option>
                                            <option value="property">Property</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 col-md-offset-4 error-message"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-4 control-label-left" for="item_code">Item Code <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="item_code" id="item_code" value="">
                                        </div>
                                        <div class="col-md-8 col-md-offset-4 error-message"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-3 control-label-left" for="parent">Parent Item</label>
                                        <div class="col-md-8">
                                            <select name="parent" id="parent" class="form-control select2">
                                            <option value="0">--none--</option><?php
                                        
                                        if($items)
                                            foreach ($items as $item)
                                                echo '<option value="'.$item['ID'].'">'.$item['DESCRIPTION'].'</option>'; ?>

                                            </select>
                                        </div>
                                        <div class="col-md-8 col-md-offset-4 error-message"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-4 control-label-left" for="description">Item Description <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="description" id="description" >
                                        </div>
                                        <div class="col-md-8 col-md-offset-4 error-message"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label class="col-md-5 control-label-left" for="unit">Unit </label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="unit" id="unit" value="">
                                        </div>
                                        <div class="col-md-7 col-md-offset-5 error-message"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label class="col-md-5 control-label-left" for="minqty">Minimum Quantity</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="minqty" id="minqty" value="">
                                        </div>
                                        <div class="col-md-7 col-md-offset-5 error-message"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label class="col-md-5 control-label-left" for="maxqty">Maximum Quantity</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="maxqty" id="maxqty" value="">
                                        </div>
                                        <div class="col-md-7 col-md-offset-5 error-message"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="button" class="btn btn-block btn-default waves-effect" onclick="Custombox.close();">Close</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_item').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>