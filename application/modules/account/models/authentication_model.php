<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Main_Model.php' );

Class authentication_model extends Main_Model 
{
	function __construct()
    {
        parent::__construct();
    }
    
	/**	
	 *	Validate user's login credentials
	 *	@param $username (string) = the user's unique username
	 *	@param $password (string) = the user's password
	 *	@return $response (array)
	 */
	public function validate_system_login($username, $password)
	{
		
		$password_check = $this->verify_password($username, $password);
		
		$returned_arg = explode("%2d", $password_check);
		// var_dump($returned_arg);
		// exit();
		if( $returned_arg[0] )
		{
			$this->db->select("EMPLOYEENO, u.id AS USERID, G.ID AS USER_GROUP, G.CODE AS ROLECODE, G.DESCRIPTION AS ROLENAME, USER_OFFICES, FIRSTNAME, MIDDLENAME, LASTNAME");
			$this->db->from('users u');
			$this->db->join('user_group G', 'G.ID = u.USER_GROUP', 'INNER');
			// $this->db->join('VW_HRS_EMPLOYEES E', 'E.EMPLOYEE_NO = U.EMPLOYEENO', 'INNER');
			$this->db->where('USERNAME', $username);
			// $this->db->where('PASSWORD', $returned_arg[1]);

			$user_data = $this->resultArray();
			// var_dump($user_data);
			// exit();
			if ($user_data)
			{
				$data = array(
	    			array(
	    					'index'	=> 'USER_OFFICES',
	    					'value'	=> $this->get_user_offices( array('USERS' => $user_data[0]['USERID']), TRUE ),
	    				),
	    		);

	    		$user_data = $this->resultArrayAppend( $user_data, $data );

				$this->session->set_userdata($user_data[0]);

				$response['login_status'] = 'success';

				//	Update the last login of a user to current timestamp
				$this->update_last_login();
			}
			else
			{
				$response['login_status'] = 'incorrect';
			}
		}
		else
		{
			$response['login_status'] = 'invalid';
		}

		return $response;
	}

	private function update_last_login()
	{
		$this->db->trans_start();

		$userid = $this->session->userdata('USERID');
		$updlog = $this->db->query("UPDATE users SET LASTLOGIN = CURRENT_TIMESTAMP WHERE ID = $userid");

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
		    $this->db->trans_rollback();
		    print('ERROR UPDATING LAST LOG');
		} else {
		    $this->db->trans_commit();
		}
	}

	protected function encrypt_password($password)
	{
		$timeTarget = 0.05; // 50 milliseconds 

		$options = [
			'cost' => 11,
			// 'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];

		do {
    		$cost = $options['cost'] + 1;
			$start = microtime(true);
			password_hash($password, PASSWORD_BCRYPT, $options);
			$end = microtime(true);
		} while (($end - $start) < $timeTarget);

		return password_hash($password, PASSWORD_BCRYPT, $options);
	}

	protected function verify_password($username, $password)
	{
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('username', $username);
		$this->db->where('active', 1);

		$query = $this->db->get();
		// var_dump($query->row(0));
		// exit();
		if ($query->num_rows() == 1) 
		{
			$result_row = $query->row(0);
			$db_password = $result_row->password;

			// if(password_verify($password, $db_password))
			// {
				return "1%2d".$db_password;
			// }
		}

		return "0%2d";
	}

	public function get_user_offices( $where_array=array(), $child=false )
	{
		$user_offices = $this->db->get_where('user_offices', $where_array);
		return $this->resultArray($user_offices);
	}
}
