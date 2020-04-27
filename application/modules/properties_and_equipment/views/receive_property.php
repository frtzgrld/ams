            
            <form method="post" id="form_receive_property" action="" role="form" class="form-horizontal">
                <input type="hidden" name="hidden_property_id" id="hidden_property_id" value="0">
                <input type="hidden" name="hidden_return_address" id="hidden_return_address" value="">
                <input type="hidden" name="hidden_action" id="hidden_action" value="insert">
                <div class="panel">
                    <header class="panel-heading">
                        <label>RECEIVE PROPERTY FORM</label>
                    </header>
                    <hr class="m-t-0 m-b-0">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">Property / Plant / Equipment</label>
                                    <div class="col-sm-12">
                                        <select class="form-control select2" name="item" id="item"><?php

                                        foreach ($items as $row): ?>
                                            <option value="<?php echo $row['ID'];?>"><?php echo $row['DESCRIPTION'];?></option><?php
                                        endforeach; ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="property_category">Category</label>
                                    <div class="col-sm-12">
                                        <select class="form-control select2" name="property_category" id="property_category">
                                            <option value="property">property</option>
                                            <option value="plant">plant</option>
                                            <option value="equipment">equipment</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="model">Brand / Model</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong" name="model" id="model" placeholder="brand/model" type="text">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="propertyno">Property No.</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong" name="propertyno" id="propertyno" placeholder="Property no." type="text">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="serialno">Serial No.</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong" name="serialno" id="serialno" placeholder="Serial no." type="text">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="unitcost">Unit Cost</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong" name="unitcost" id="unitcost" placeholder="" type="text">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="quantity">Quantity</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong" name="quantity" id="quantity" placeholder="" type="text">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="dateacquired">Date Acquired</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong datepicker-autoclose" name="dateacquired" id="dateacquired" placeholder="" type="text">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="useful_life">Est. Useful Life</label>
                                    <div class="col-sm-12">
                                        <input class="form-control text-strong" name="useful_life" id="useful_life" placeholder="" type="text">
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" for="eul_unit">Useful Life Unit</label>
                                    <div class="col-sm-12">
                                        <select class="form-control select2" name="eul_unit" id="eul_unit">
                                            <option value="year">year</option>
                                            <option value="month">month</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 error-message"></div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="reset" class="btn btn-block btn-default waves-effect">Reset</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_receive_property').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <script src="<?php echo base_url(); ?>assets/js/ams/form_receive_property.js"></script>
