            
            <form method="post" id="form_distribute_supply" action="" role="form" class="form-horizontal">
                <input type="hidden" name="hidden_distrib_id" id="hidden_distrib_id" value="0">
                <input type="hidden" name="hidden_return_address" id="hidden_return_address" value="">
                <input type="hidden" name="hidden_action" id="hidden_action" value="insert">
                <div class="panel">
                    <header class="panel-heading m-b-0">
                        <label>ISSUE SUPPLY FORM</label>
                    </header>
                    <hr class="m-t-0 m-b-0">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Item Description</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="item" id="item"><?php

                                foreach ($items as $row): ?>
                                    <option value="<?php echo $row['ID'];?>"><?php echo $row['DESCRIPTION'];?></option><?php
                                endforeach; ?>

                                </select>
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Issue to Office</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="office" id="office"><?php

                                foreach ($office as $row): ?>
                                    <option value="<?php echo $row['ID'];?>"><?php echo $row['DESCRIPTION'];?></option><?php
                                endforeach; ?>

                                </select>
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Quantity</label>
                            <div class="col-sm-6">
                                <input class="form-control text-strong" name="quantity" id="quantity" placeholder="" type="text">
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Issued</label>
                            <div class="col-sm-6">
                                <input class="form-control text-strong datepicker-autoclose" name="dateissued" id="dateissued" placeholder="" type="text">
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="reset" class="btn btn-block btn-default waves-effect">Reset</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_distribute_supply').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <script src="<?php echo base_url(); ?>assets/js/eis/form_distribute_supply.js"></script>