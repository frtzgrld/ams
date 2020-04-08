		
<!-- <pre><?php print_r($user_info); ?></pre> -->
<?php
	if( $user_info )
        foreach ($user_info as $row): 
        
        ?>
            
		<div class="row">
            <div class="col-lg-8">
            	<div class="panel panel-custom panel-border">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                        	<small class="text-default">USER ACCOUNT OF</small>
                        	<br/><?php echo $row['EMPLOYEENO']; ?> <br/> <?php echo $row['FIRSTNAME'].' '.$row['LASTNAME']; ?>
                            <br/><?php echo $row['USER_GROUP'][0]['DESCRIPTION']; ?> 
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table m-0">
                        	<thead>
                        		<tr>
                        			<th width="30%"></th>
                        			<th width="70%"></th>
                        		</tr>
                        	</thead>
                        	
                        	<tfoot class="hidden">
                        		<tr>
                        			<td colspan="2"></td>
                        		</tr>
                        	</tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            	<div class="card-box widget-user">
                    <div>
                        <img src="<?php echo base_url(); ?>assets/images/users/noprofile.png" style="width:60px; height:60px" class="img-responsive img-circle" alt="user">
                        <div class="wid-u-info" style="margin-left: 80px">
                            <h4 class="m-t-0 m-b-5">
                                <small>Last logged in:</small>
                            </h4>
                            <p class="text-muted m-b-5 font-13"><?php echo date_format( date_create($row['LASTLOGIN']), 'F d, Y'); ?></p>
                            <small class="text-custom"><b><?php echo profile('EMPLOYEENO', $row['EMPLOYEENO'], 'OFFICES'); ?></b></small>
                        </div>
                    </div>
                </div>

                <div class="card-box">
                    <h5 class="m-t-0">Action</h5>
                	<div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo base_url('account/users');?>" class="btn btn-default btn-block btn-trans waves-effect waves-default m-b-5">Back to User list</a>
                        </div>
                        
                       
                    </div>
                </div>
            </div>
        </div>

        <hr class="m-t-0">

        <?php

    endforeach; ?>

    <script type="text/javascript">

        function toggleDeleteOffice( user_office_id )
        {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                confirmButtonText: 'Remove!'
            },
            function(isConfirm){
                if(isConfirm)
                {
                    $.ajax({
                        url: base_url + 'account/users/remove_user_office',
                        method: 'POST',
                        data: {user_office_id: user_office_id},
                        cache: false,
                        dataType: 'json',
                        async: true,
                        error: function(response)
                        {
                            alert('error');
                        },
                        success: function(response)
                        {
                            switch(response['result'])
                            {
                                case 'success':
                                    swal(response['header'], response['message'], "success");
                                    setTimeout(function(){
                                        window.location.reload();
                                    },  1000 );
                                    break;

                                default:
                                case 'error':
                                    break;
                            }
                        }
                    });
                }
            });
        }

    </script>