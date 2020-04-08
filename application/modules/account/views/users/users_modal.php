
        <a id="hidden_user_button" href="#user_modal" class="btn btn-info btn-block waves-effect waves-light hidden" data-animation="door" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" ></a>

        <div id="user_modal" class="modal door" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:90%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="Custombox.close();">
                            <span>×</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="custom-width-modalLabel">USER ACCOUNT FORM</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_user" action="" method="post" class="form-horizontal" role="form" >
                            <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="0">
                            <input type="hidden" name="action" id="action" value="insert">
                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="employee">Employee No: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                <input type="text" class="form-control" name="employee" id="employee">
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="firstname">First Name: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                <input type="text" class="form-control" name="firstname" id="firstname">
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="middlename">Middle Name: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                <input type="text" class="form-control" name="middlename" id="middlename">
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="lastname">Last Name: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                <input type="text" class="form-control" name="lastname" id="lastname">
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="office">Office: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" name="office" id="office">
                                        <option></option><?php

                                    if( $offices )
                                        foreach ($offices as $o) {
                                            echo '<option value="'.$o['ID'].'">'.$o['DESCRIPTION'].'</option>';
                                        }   ?>

                                    </select>
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="user_group">User Group: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" name="user_group" id="user_group">
                                        <option></option><?php

                                    if( $user_groups )
                                        foreach ($user_groups as $g) {
                                            echo '<option value="'.$g['ID'].'">'.$g['DESCRIPTION'].'</option>';
                                        }   ?>

                                    </select>
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="username">Username: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="username" id="username">
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="password">Password: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="password" id="password">
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="button" class="btn btn-block btn-default waves-effect" onclick="Custombox.close();">Close</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_user').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#form_user").validate({
                    ignore:'',
                    rules: {
                        hidden_user_id: {
                            required: true,
                            maxlength: 11,
                            number: true,
                        },
                        employee: {
                            required: true,
                            maxlength: 30,
                        },
                        user_group: {
                        	required: true,
                        	maxlength: 11,
                        },
                        username: {
                            required: true,
                            maxlength: 50,
                        },
                        password: {
                            required: true,
                            maxlength: 50,
                        },
                    },

                    errorPlacement: function (error, element) {
                        $(element).closest('.form-group').find('.error-message').html(error);
                    },

                    submitHandler: function() {
                        $.ajax({
                            url: base_url + 'account/users/validate_users_update',
                            method: 'POST',
                            data: $('#form_user').serialize(),
                            cache: false,
                            dataType: 'json',
                            async: true,
                            error: function(response)
                            {
                                alert('error');
                            },
                            success: function(response)
                            {
                                Custombox.close();
                                switch( response['result'] )
                                {
                                    case 'success':
                                        $('#datatable_users').DataTable().ajax.reload(null, true);
                                        setTimeout(function(){
                                            swal(response['header'], response['message'], "success");
                                        },  500 );
                                        setTimeout(function(){
                                            if( response['redirect'] )
                                                window.location.href = response['redirect'];
                                        },  1000 );
                                        break;

                                    default:
                                        break;
                                }
                            }
                        });
                    }
                });
            }
            function toggle_user( user_id )
            {
                $('#hidden_user_id').val('0');
                $('#action').val("insert");
                $('#employee').val('').trigger('change');
                $('#user_group').val('').trigger('change');
                $('#username').val('')
                $('#password').val('');

                if( user_id )
                {
                    $.ajax({
                        url: base_url + 'account/users/get_user_detail',
                        method: 'POST',
                        data: {user_id: user_id},
                        cache: false,
                        dataType: 'json',
                        async: true,
                        error: function(response)
                        {
                            alert('error');
                        },
                        success: function(response)
                        {
                            if( response )
                            {
                                $('#hidden_user_id').val(response[0]['USERID']);
                                $('#action').val('update');
                                $('#employee').val(response[0]['EMPLOYEENO']).trigger('change');
                                $('#user_group').val(response[0]['USER_GROUP']).trigger('change');
                                $('#office').val(response[0]['USER_OFFICES']).trigger('change');
                                $('#username').val(response[0]['USERNAME'])
                                $('#password').val(response[0]['PASSWORD']);
                                $('#firstname').val(response[0]['FIRSTNAME']);
                                $('#middlename').val(response[0]['MIDDLENAME']);
                                $('#lastname').val(response[0]['LASTNAME']);
                                
                            }
                        }
                    });
                }
                
                $('#hidden_user_button').click();
            }

        </script>