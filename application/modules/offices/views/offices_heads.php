
        <div class="panel panel-custom panel-border">
            <div class="panel-heading">
                <h4 class="panel-title">Office / Department Heads</h4>
            </div>
            <hr class="m-t-10 m-b-0">
            <form id="form_office_heads" action="" method="post" class="form-horizontal" role="form">
                <input type="hidden" name="action" value="insert">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-condensed">
                            <thead>
                                <tr class="table-eis">
                                    <th width="40%">Offices</th>
                                    <th width="30%">Head</th>
                                    <th width="30%">Designation</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-p-l-20"><?php

                            foreach ($office_heads as $head): ?>

                                <tr>
                                    <td class="text-middle">
                                        <?php echo $head['OFFICE']; ?>
                                        <input type="hidden" class="form-control" name="office[]" value="<?php echo $head['OFFICEID']; ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-strong" name="fullname[]" value="<?php echo $head['FULLNAME']; ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-strong" name="designation[]" value="<?php echo $head['DESIGNATION']; ?>">
                                    </td>
                                </tr><?php

                            endforeach; ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>
                                        <button class="btn btn-block btn-success m-t-10" type="button" onclick="jQuery($('#form_office_heads').submit())">SAVE</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/eis/form_office_heads.js"></script>