<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'modules/account/models/authentication_model.php' );

Class User_Model extends Authentication_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	public function fetch_datable_offices()
	{
        $tableset = array(
                'object'    => 'users',
                'index'     => 'ID',
                'join'      => NULL,
                'where'     => 'where active = 1',
                'group'     => NULL,
                'columns'   => array(
                        'EMPLOYEENO',
                        'CONCAT(FIRSTNAME," ",LASTNAME)',
                        'USER_OFFICES',
                        'LASTLOGIN',
                        'ACTIVE',
                        'ID',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset );
	}


    public function fetch_user_detail( $user_id=null, $join_refference=false )
    {
        $result = $this->resultArray('users', array('ID' => $user_id));

        if( $join_refference === true )
        {
            $result[0]['OFFICE'] = $this->user_offices(array('users' => $result[0]['ID'], 'ACTIVE' => 1), TRUE, NULL);
            $result[0]['USER_GROUP'] = $this->user_groups(array('ID' => $result[0]['USER_GROUP'], 'ACTIVE' => 1), TRUE, NULL);
        }

        return $result;
    }


    public function get_user_profile( $key_name, $key_value, $target_column )
    {
		$this->db->select($target_column);
		$this->db->from('users');
		$this->db->join('user_offices', 'users.id = user_offices.users', 'left');
		$this->db->join('offices', 'user_offices.offices = offices.id', 'left');
		$this->db->where($key_name, $key_value);

        return $this->resultRow($target_column);
    }


    public function manage_user_account( $input )
    {
        $this->db->trans_start();
        
        $data = array(
                'EMPLOYEENO'    => $input['employee'],
                'FIRSTNAME'     => $input['firstname'],
                'MIDDLENAME'    => $input['middlename'],
                'LASTNAME'      => $input['lastname'],
                'USER_GROUP'    => $input['user_group'],
                'USERNAME'      => $input['username'],
                'PASSWORD'      => $input['password'],
                'USER_OFFICES'  => $input['office'],
                'LASTLOGIN'     => NULL,
                'ACTIVE'        => 1
            );

        $this->db->insert('USERS', $data);

        $user_id = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return array(
                    'result'    => 'error', 
                    'header'    => 'FAILED', 
                    'message'   => 'Record cannot be saved right now. Try reloading page', 
                );
        }
        else
        {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success', 
                    'header'    => 'SUCCESS', 
                    'message'   => 'User account has been saved.',
                    'redirect'  => base_url().'account/users/user_detail/'.$user_id,
                );
        }
    }


    public function get_employee_list( $input=null )
    {
        if( $input )
        {
            $offices = $this->user_offices(array('users' => $this->session->userdata('USERID')), false, 'offices');

            $this->db->select('concat(u.FIRSTNAME, " " , u.MIDDLENAME, " " , u.LASTNAME) as FULLNAME, u.ID AS USERID, EMPLOYEENO, o.ID AS OFFICEID, o.DESCRIPTION AS OFFICE_DESC, uo.DESIGNATION', FALSE);
            $this->db->from('users u');
            $this->db->join('user_offices uo', 'uo.USERS = u.ID', 'LEFT');
            $this->db->join('offices o', 'o.ID = uo.OFFICES', 'LEFT');
            $this->db->where('u.ACTIVE', 1);
            $this->db->where('uo.ACTIVE', 1);

            if( $input['office'] == 'in_office' )
            {
                // $offices = $this->user_offices(array('USERS' => $this->session->userdata('USERID')), false, 'OFFICES');
                $this->db->where('o.ID IN '.$offices);
            }

            $this->db->order_by('FULLNAME');

            return $this->resultArray();
        }
        else
        {
            $this->db->select('concat(FIRSTNAME, " " , MIDDLENAME, " " , LASTNAME) as FULLNAME, ID AS USERID , EMPLOYEENO ');
            $this->db->from('users');
            $this->db->order_by('lastname', 'ASC');

            return $this->resultArray();
        }
    }


    public function user_offices( $where_array=null, $join_refference=false, $as_array_index=null )
    {
        $user_offices = $this->db->get_where('USER_OFFICES', $where_array);

        $result = $this->resultArray($user_offices);

        if( $as_array_index != null && is_string($as_array_index) )
        {
            $offices_in_array = '(';

            foreach ($result as $row) {
                $offices_in_array .= $row[$as_array_index].",";
            }

            return rtrim($offices_in_array,',').")";
        }
        else
        {
            if( $join_refference === true )
            {
                for ($a=0; $a<count($result); $a++) 
                {
                    $query = $this->db->get_where('OFFICES', array('ID' => $result[$a]['OFFICES']));
                    $result[$a]['OFFICES'] = $this->resultArray($query);
                }
            }
        }

        return $result;
    }

    public function user_groups( $where_array=null, $join_refference=false, $as_array_index=null )
    {
        $user_offices = $this->db->get_where('USER_GROUP', $where_array);

        $result = $this->resultArray($user_offices);

        if( $as_array_index != null && is_string($as_array_index) )
        {
            $offices_in_array = '(';

            foreach ($result as $row) {
                $offices_in_array .= $row[$as_array_index].",";
            }

            return rtrim($offices_in_array,',').")";
        }
        else
        {
            if( $join_refference === true )
            {
                for ($a=0; $a<count($result); $a++) 
                {
                    $query = $this->db->get_where('USER_GROUP', array('ID' => $result[$a]['ID']));
                    $result[$a]['USER_GROUP'] = $this->resultArray($query);
                }
            }
        }

        return $result;
    }


    /**
     *  Get custom permissions granted to a user
     *  @param $account_no (string) = the user account number
     *  @return array
     */
    public function getUserCustomAccess( $account_no=string )
    {
        $this->db->select('up.id AS permission_id, up.tcode, tc.description, approval' );
        $this->db->select('module, u.display_name AS grantedby, dategranted, dateexpire, active');
        $this->db->select(
            "(CASE  WHEN tc.operation = 'r' THEN 'Read / View'
                    WHEN tc.operation = 'c' THEN 'Create'
                    WHEN tc.operation = 'u' THEN 'Update'
                    WHEN tc.operation = 'd' THEN 'Delete'
                    WHEN tc.operation = 'a' THEN 'Activate'
                    WHEN tc.operation = 'i' THEN 'Deactivate / Cancel'
                    ELSE 'unknown' END) AS operation");
        $this->db->from('users_permissions up');
        $this->db->join('users a', 'a.id = up.userid', 'inner');
        $this->db->join('users u', 'u.id = up.grantedby', 'inner');
        $this->db->join('transaction_codes tc', 'tc.tcode = up.tcode', 'inner');
        $this->db->where('a.account_no', $account_no);

        return $this->resultArray();
    }

	public function countActiveUser()
	{
		$this->db->select('COUNT(id) AS activeusers');
		$this->db->from('user');
		$this->db->where('flag', 1);
		
		return $this->db->get()->row('activeusers');
	}

    public function updateProfilePhoto( $input=array(), $file=array() )
    {
        $this->db->trans_start();
        
        //  delete the old photo file
        $this->db->select('avatar')->from('users')->where('account_no', $input['hidden_accountno']);
        $old_photo = $this->db->get();

        if( $old_photo->num_rows() > 0 ) 
        {
            if( $old_photo->row()->avatar != 'noprofile.png' )
                unlink( ASSPATH.'images/profile/users/'.$old_photo->row()->avatar);
        }

        //  insert the new photo data
        $data = array(
                'avatar'    => $file['file_name'],
            );

        $this->db->where('account_no', $input['hidden_accountno']);
        $this->db->update('users', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return array(
                    'result'    => 'error', 
                    'header'    => 'UPLOAD FAILED', 
                    'message'   => 'Record cannot be updated right now. Try reloading page', 
                );
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_userdata('account_image', $file['file_name']);
            return array(
                    'result'    => 'success', 
                    'header'    => 'UPLOAD SUCCESS', 
                    'message'   => 'You had successfully change your profile photo', 
                );
        }
    }

    public function updateCredentials( $input=array() )
    {
        $this->db->trans_start();
        
        $data = array(
                'username'      => $input['pro_username'],
                'password'      => $this->encryptPassword($input['pro_password']),
            );

        $this->db->where('account_no', $input['hidden_accountno']);
        $this->db->update('users', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return array(
                    'result'    => 'error', 
                    'header'    => 'UPDATE FAILED', 
                    'message'   => 'Credentials cannot be updated right now. Try reloading page', 
                );
        }
        else
        {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success', 
                    'header'    => 'UPDATE SUCCESS', 
                    'message'   => 'Credentials has been successfully updated', 
                );
        }
    }

    public function updateProfilePersonal( $input=array() )
    {
        $this->db->trans_start();
        
        $data = array(
                'display_name'  => $input['f_display_name'],
                'designation'   => $input['f_designation'],
            );

        $this->db->where('id', $input['hidden_userid']);
        $this->db->update('users', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return array(
                    'result'    => 'error', 
                    'header'    => 'UPDATE FAILED', 
                    'message'   => 'Profile cannot be updated right now. Try reloading page', 
                );
        }
        else
        {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success', 
                    'header'    => 'UPDATE SUCCESS', 
                    'message'   => 'Profile has been successfully updated', 
                );
        }
    }

    public function getPendingRegistration()
    {
        $this->db->select('u.id, account_no, display_name, u.datecreated, g.rolename, d.division');
        $this->db->from('users u');
        $this->db->join('user_group g', 'g.rolecode = u.user_group', 'inner join');
        $this->db->join('nwrb_divisions d', 'd.id = u.division', 'inner join');
        $this->db->where('confirmed', 0);
        $this->db->order_by('u.datecreated', 'asc');

        return $this->resultArray();
    }

    public function confirmRegistration( $userid=int )
    {
        $this->db->trans_start();
        
        $data = array(
                'flag'      => 1,
                'confirmed' => 1,
            );

        $this->db->where('id', $userid);
        $this->db->update('users', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return array(
                    'result'    => 'error', 
                    'header'    => 'CAN\'T CONFIRM', 
                    'message'   => 'Registration cannot be confirmed right now. Try reloading page.', 
                );
        }
        else
        {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success', 
                    'header'    => 'CONFIRMED', 
                    'message'   => 'Reh=gistration has been successfully confirmed and set to active.', 
                );
        }
    }

    public function remove_user_office( $user_office_id=null )
    {
        $this->db->trans_start();

        $this->db->where('ID', $user_office_id);
        $this->db->update('USER_OFFICES', array('ACTIVE' => 0));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return array(
                    'result'    => 'error', 
                    'header'    => 'CAN\'T REMOVE', 
                    'message'   => 'An error has been encountered in attempt to remove this record.', 
                );
        }
        else
        {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success', 
                    'header'    => 'SUCCESS', 
                    'message'   => 'User\' assignment to the selected office has been successfully set as inactive.', 
                );
        }
    }

    public function crud_users($post)
    {
        if ($post['action'] == 'delete'){
            $data = array(
                'active' => 0,
                
            );
            $this->db->where('id', $post['id']);
            $this->db->update('users', $data);
            $new_id = $post['id'];
        }

        return "success";
       
    }

    public function office_list()
    {
        $this->db->select('ID, CODE, DESCRIPTION, ACRONYM, CATEGORY, AIP_ORDER');
        $this->db->from('offices');
        $this->db->where('ACTIVE', 1);

        $this->db->order_by('DESCRIPTION');

        return $this->resultArray();
    }

    public function update_user_account( $input=array() )
    {
        $this->db->trans_start();
        
        $data = array(
            'EMPLOYEENO'    => $input['employee'],
            'FIRSTNAME'     => $input['firstname'],
            'MIDDLENAME'    => $input['middlename'],
            'LASTNAME'      => $input['lastname'],
            'USER_GROUP'    => $input['user_group'],
            'USERNAME'      => $input['username'],
            'PASSWORD'      => $input['password'],
            'USER_OFFICES'  => $input['office'],
            'LASTLOGIN'     => date('Y-m-d h:i:s'),
            'ACTIVE'        => 1
            );

        $this->db->where('id', $input['hidden_user_id']);
        $this->db->update('users', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return array(
                    'result'    => 'error', 
                    'header'    => 'UPDATE FAILED', 
                    'message'   => 'Credentials cannot be updated right now. Try reloading page', 
                );
        }
        else
        {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success', 
                    'header'    => 'UPDATE SUCCESS', 
                    'message'   => 'User has been successfully updated', 
                );
        }
    }
}
