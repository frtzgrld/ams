            
            <form method="post" id="form_distribution_property" action="" role="form" class="form-horizontal">
                <input type="hidden" name="hidden_distribution_id" id="hidden_distribution_id" value="0">
                <input type="hidden" name="hidden_action" id="hidden_action" value="insert">
                <div class="panel">
                    <header class="panel-heading m-b-0">
                        <label>DISTRIBUTION PROPERTY FORM</label>
                    </header>
                    <hr class="m-t-0 m-b-0">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Property</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="property" id="property" onchange="getPropertyNos('free')"><?php

                            if( $properties )
                                foreach ($properties as $p): ?>
                                    <option value="<?php echo $p['ID'];?>"><?php echo $p['DESCRIPTION'];?></option><?php
                                endforeach; ?>

                                </select>
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Quantity:</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="quantity" id="quantity" placeholder="Quantity" type="text">
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Property no.:</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="propertyno" id="propertyno">
                                </select>
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Assigned to/ Responsible person:</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="assignedto" id="assignedto"><?php

                            if( $employees )
                                foreach ($employees as $e): ?>
                                    <option value="<?php echo $e['EMPLOYEENO'];?>"><?php echo $e['FULLNAME'];?></option><?php
                                endforeach; ?>

                                </select>
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">-- Office:</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="office" id="office"><?php

                            if( $offices )
                                foreach ($offices as $o): ?>
                                    <option value="<?php echo $o['ID'];?>"><?php echo $o['DESCRIPTION'];?></option><?php
                                endforeach; ?>

                                </select>
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date assigned:</label>
                            <div class="col-sm-6">
                                <input class="form-control datepicker-autoclose" name="assigneddate" id="assigneddate" placeholder="Date assigned" type="text">
                            </div>
                            <div class="col-sm-3 error-message"></div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-9">
                                <button class="btn btn-success btn-block waves-effect waves-light m-b-5" type="button" onclick="jQuery($('#form_distribution_property').submit())">SAVE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <script src="<?php echo base_url(); ?>assets/js/eis/form_distribution_property.js"></script>