        
        <div class="row m-b-10">
            <div class="col-sm-4">
                <button onclick="toggle_user(null)" class="btn btn-success btn-block waves-effect waves-light" type="button"><i class="fa fa-plus"></i> ADD USER ACCOUNT</button>
                <a id="hidden_user_button" href="#user_modal" class="btn btn-info btn-block waves-effect waves-light hidden" data-animation="door" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" ></a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_users" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="15%">Employee No.</th>
                                <th width="25%">Fullname</th>
                                <th width="20%">Office/Unit</th>
                                <th width="15%">Last logged in</th>
                                <th width="10%">Is active</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
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
                                <input type="text" class="form-control" name="employee" id="employee" />
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
                                $('#hidden_user_id').val(response[0]['ID']);
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

        <script type="text/javascript">

            $(document).ready(function () {

                $('#datatable_users').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'account/users/datatable_users',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-info btn-xs btn-icon icon-left' href='" + base_url + 'account/users/user_detail/' + aData[5] + "'><i class='ti ti-info-alt'></i> Detail</a>" + "<button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_user(" + aData[5] + ")'><i class='ti ti-pencil-alt'></i> Edit</button>" + "<button class='btn btn-danger waves-effect waves-light btn-xs' onclick='deleteItem(" + aData[5] + ")'><i class='ti zmdi-delete'></i> Delete</button>"; 
                            // + "<button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_user(" + aData[5] + ")'><i class='ti ti-pencil-alt'></i> Edit</button>";

                        $('td:eq(0)', nRow).html( aData[0] );
                        $('td:eq(1)', nRow).html( aData[1] );
                        $('td:eq(2)', nRow).html( aData[2] );
                        $('td:eq(3)', nRow).html( aData[3] );
                        $('td:eq(4)', nRow).html( aData[4]==1 ? 'Yes' : 'No' );
                        $('td:eq(5)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-center"},
                        {"sClass": "text-left"},
                    ]
                });

                $('#dt-search').keyup(function(){
                    $('#datatable_users').DataTable().search($(this).val()).draw() ;
                });

                $("#form_user").validate({
                    ignore:'',
                    rules: {
                        hidden_user_id: {
                            required: true,
                            maxlength: 11,
                            number: true,
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
                            url: base_url + 'account/users/validate_users',
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
                                        break;

                                    default:
                                        break;
                                }
                            }
                        });
                    }
                });

                deleteItem = function(id){
                    swal({
                        title: "Confirmation",
                        text: "Are you sure you want to delete this user?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }, function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                  url: "", 
                                  type: "POST",             
                                  data: {
                                    action : 'delete',
                                    id : id
                                  }, 
                                  dataType: 'json',    
                                  success: function(data){
                                        swal("Deleted!", "User has been successfully deleted.", "success");
                                        location.reload();
                                  },
                                  error : function(data){
                                    swal("Error!", "Something went wrong. Please reload the page and try again.", "error");
                                  }
                              });
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
                }
            });

            function toggleDeleteAlert( user_id )
            {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger waves-effect waves-light',
                    confirmButtonText: 'Delete!'
                });
            }

        </script>