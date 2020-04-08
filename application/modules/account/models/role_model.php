<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Main_Model.php' );

Class Role_Model extends Main_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    protected function getRoleRank( $rolecode='' )
    {	
    	$this->db->select('ranking');
		$this->db->from('user_group');
		$this->db->where('rolecode', $rolecode);

		$ranks = $this->db->get();

		if( $ranks->num_rows() > 0 )
			return $ranks->row()->ranking;

		return null;
    }

    /**
     *	Get list of roles for various purposes
     *	@param $rolecode (string) = optional: the rolecode of a logged in user
     *	@return array
     */
	public function getRoleList( $rolecode=null )
	{
		$accounts = null;
		$rank = $this->getRoleRank($rolecode);

		$this->db->select('g.id as role_id, rolename, rolecode, count(u.id) as members');
		$this->db->from('user_group g');
		$this->db->join('users u', 'g.rolecode = u.user_group', 'left');

		if( $rolecode )
			$this->db->where('ranking >=', $rank);

		$this->db->group_by('g.id, rolename, rolecode');

		$user_accounts = $this->db->get();

		if( $user_accounts->num_rows() > 0 ) {
			foreach ($user_accounts->result() as $rows) {
				$accounts[] = array(
					$rows->rolename,
					$rows->rolecode,
					$rows->members,
					$rows->role_id,
					$this->getRoleCoverage( $rows->rolecode ),
				);
			}
		}

		return $accounts;
	}

	public function fetch_user_groups( $usage=NULL )
	{
		$this->db->select('*')->from('user_group')->where('ACTIVE', 1)->order_by('DESCRIPTION', 'ASC');

		return $this->resultArray();
	}
	
	public function fetch_datatable_roles()
	{
        return $this->DataTable( 
        	$this->activegroup, 
        	array(
		        'object'	=> 'VW_USER_GROUPS',
		        'index' 	=> 'ROLEID',
		        'join'		=> null,
		        'where'		=> null,
		        'group'		=> null,
		        'columns' 	=> array(
		                'CODE',
		                'DESCRIPTION',
		                'ACTIVE_USERS',
		                'ROLEID',
		            ),
	            )
        	);
    }

	public function getRoleCoverage( $rolecode='' )
	{
		$this->db->select('COUNT(id) AS coverage');
		$this->db->from('access_rights');

		if( $rolecode )
			$this->db->where('rolecode', $rolecode);

		$coverage = $this->db->get();

		if( $coverage->num_rows() > 0 )
		{
			$coverage = (int) $coverage->row()->coverage;
			$tcodes = $this->db->count_all('transaction_codes');
			
			return array(
					'total_rights' 	=> $coverage,
					'total_tcodes' 	=> $tcodes,
					'percentage'	=> number_format( 100*($coverage/$tcodes), 0),
				);
		}

		return '0';
	}

	public function get_role_detail( $where_array=null, $access_coverage=false )
	{
		$details = $this->db->get_where('VW_USER_GROUPS', $where_array);

		$user_accounts = $this->resultArray($details);

		if( $user_accounts ) 
		{
			for( $x=0; $x<count($user_accounts); $x++ ) 
			{
				$coverage = NULL;
				$user_accounts[$x]['COVERAGE'] = $coverage;
			}
		}

		return $user_accounts;
	}

	/**
	 *	Get all modules (distinct) with the number of operations/tcodes under it
	 *	@param $get_ops (Boolean) = set to 'true' if want to include operations/tcodes under it
	 *	@param $rolecode (string) = set to optionally get permission for an operation under a module
	 *	@return object
	 */
	public function getModule( $get_ops=false, $rolecode='' )
	{
		$module_set = null;

		$this->db->select('module, COUNT(module) AS total_ops');
		$this->db->from('transaction_codes');
		$this->db->group_by('module');
		$this->db->order_by('module', 'asc');

		$tcodes = $this->db->get();

		if( $tcodes->num_rows() > 0 )
		{
			foreach ($tcodes->result() as $rows) 
			{
				$operations = ($get_ops==FALSE)?'void':$this->getTransactionCode( NULL, $rows->module, $rolecode );

				$module_set[] = array (
					'modules'		=>	$rows->module,
					'colspan'		=>	$rows->total_ops,
					'operations'	=>	$operations,
				);
			}

			return $module_set;
		}

		return null;
	}

	/**
	 *	Get transaction codes
	 *	@param $tcode (string) = whether to optionally get a transaction code record via unique tcode
	 *	@param $module (string) = whether to optionally get transaction codes via module(module) name
	 *	@return array
	 */
	public function getTransactionCode( $tcode='', $module='', $rolecode='' )
	{
		$tcode_set = null;

		$this->db->select('tcode, operation, description');
		$this->db->select("(case when operation = 'r' then 1 
			when operation = 'c' then 2 when operation = 'u' then 3 
			when operation = 'd' then 4 when operation = 'a' then 5 
			when operation = 'i' then 6 when operation = 'p' then 7 else 8 end) as 'rank'");
		$this->db->from('transaction_codes');

		if( strlen($tcode) > 0 ) 	$this->db->where('tcode', $tcode);
		if( strlen($module) > 0 )	$this->db->where('module', $module);

		$this->db->order_by('rank', 'asc');

		$modules = $this->db->get();

		if( $modules->num_rows() > 0 )
		{
			foreach ($modules->result() as $rows) 
			{
				$rolecode = ($rolecode=='')?NULL:$rolecode;

				$tcode_set[] = array (
					'tcode'			=>	$rows->tcode,
					'operation'		=>	$rows->operation,
					'description'	=>	$rows->description,
					'permission' 	=>	$this->getPermission( $rolecode, $rows->tcode ),
				);
			}

			return $tcode_set;
		}

		return null;
	}

	/**
	 *	Get permission given to a user group or a user account
	 *	@param $rolecode (string) = set this to get all permission given to a user group
	 *	@param $tcode (string) = set this to get all user group that permissible to access it
	 *	@return array || string
	 */
	public function getPermission( $rolecode='', $tcode='' )
	{
		$this->db->select('id, rolecode, tcode, approval');
		$this->db->from('access_rights');

		if( $rolecode )
			$this->db->where('rolecode', $rolecode);

		$this->db->where('tcode', $tcode);

		$permission = $this->db->get();

		if( $permission->num_rows() > 0 )
			return $permission->result_array();
		
		return 'NA';	//	ie. no permission
	}

	public function getRoleAccesses( $rolecode='', $tcode='')
	{
		// $accounts = null;

		// $this->db->select('rolename, rolecode');
		// $this->db->from('role r');
		// $this->db->order_by('rank', 'asc');

		// $user_accounts = $this->db->get();

		// if( $user_accounts->num_rows() > 0 ) {
		// 	foreach ($user_accounts->result() as $rows) {
		// 		$accounts[] = array(
		// 			'rolename'	=>	$rows->rolename,
		// 			'rolecode'	=>	$rows->rolecode,
		// 			'access'	=>	$this->getAccessRights( $rows->rolecode ),
		// 		);
		// 	}
		// }

		$this->db->select('rolecode, tcode, approval');
		$this->db->from('access_rights');
		$this->db->where('rolecode', $rolecode);

		if( $tcode !== '' )
			$this->db->where('tcode', $tcode);

		$access_result = $this->db->get();

		if( $access_result->num_rows() > 0 )
			return $access_result->result_array();

		return null;
	}

	// public function getAccessRights( $rolecode='', $module='r' )
	// {
	// 	$tcodes_set = null;

	// 	// i stopped here
	// 	$this->db->select('rar.tcode, rar.approval');
	// 	// $this->db->select('(CASE WHEN operation = "r" THEN 1 WHEN operation = "c" THEN 2 WHEN operation = "u" THEN 3 WHEN operation = "d" THEN 4 WHEN operation = "a" THEN 5 WHEN operation = "i" THEN 6 ELSE 7 END) AS rank');
	// 	$this->db->from('access_rights rar');
	// 	$this->db->join('transaction_codes tc', 'tc.tcode = rar.tcode', 'left');
	// 	$this->db->where('rolecode', $rolecode);
	// 	// $this->db->order_by('rank', 'asc');

	// 	$tcodes = $this->db->get();

	// 	if( $tcodes->num_rows() > 0 )
	// 	{
	// 		foreach ($tcodes->result() as $rows) 
	// 		{
	// 			$tcodes_set[] = array (
	// 				'tcodes'		=>	$rows->tcode,
	// 				'approval'		=>	$rows->approval,
	// 			);
	// 		}

	// 		return $tcodes_set;
	// 	}

	// 	return null;
	// }

	public function countActiveUser()
	{
		$this->db->select('COUNT(id) AS activeusers');
		$this->db->from('user');
		$this->db->where('flag', 1);
		
		return $this->db->get()->row('activeusers');
	}

	public function getUserGroups()
	{
		$this->db->select('id, rolename, rolecode')->from('user_group')->order_by('ranking', 'asc');

		$user_group = $this->db->get();

		if( $user_group->num_rows() > 0 )
			return $user_group->result_array();

		return false;
	}

	public function managePermission( $input=array() )
	{
		$data = array(
				'rolecode'	=> $input['f_per_rolecode'],
				'tcode'		=> $input['hidden_tcode'],
			);

		$this->db->trans_start();

		if( isset($input['f_per_state']) )
		{
			if( $this->ifPermissionExist( $data ) === FALSE )
			{
				$this->db->insert('access_rights', $data);
			}
			else
			{
				return array(
						'result'	=> 'info',
						'message'	=> 'No granting of permission has been made. Permission already exist.',
					);
			}
			
		}
		else
		{
			if( $this->ifPermissionExist( $data ) === TRUE )
			{
				$this->db->where('rolecode', $input['f_per_rolecode']);
				$this->db->where('tcode', $input['hidden_tcode']);
				$this->db->delete('access_rights');
			}
			else
			{
				return array(
						'result'	=> 'info',
						'message'	=> 'No revocation of permission has been made. Permission does not exist.',
					);
			}
		}

		$this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return array(
                    'result'    => 'error',
                    'message'   => 'Permission cannot be saved right now. Try reloading page.',
                );
        }
        else
        {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success',
                    'message'   => 'Permission has been successfully updated.',
                );
        }
	}

	/**
	 *	Check if the permission already exist
	 *	@param $input (array) = the posted form values
	 *	@param boolean
	 */
	protected function ifPermissionExist( $input=array() )
	{
		$result = $this->db->get_where('access_rights', $input);

		if( $result->num_rows() > 0 )
			return TRUE;

		return FALSE;
	}
}
