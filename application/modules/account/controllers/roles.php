<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'controllers/Main_Control.php' );

Class Roles extends Main_Control 
{
	protected $pagename = 'Account Management';

	function __construct()
	{
		parent::__construct();

		$this->load->model('role_model');

		define('ROLE', 'Role Management');
	}

	public function index()
	{
		$this->check_permissions( ROLE, 'r' );
		
		$data = array(
				'page'			=> $this->pagename,
				'header'		=> 'User Groups',
				'menu' 			=> 'accounts',
				'submenu' 		=> 'roles',
				'title'			=> 'User Groups'
			);

		$this->get_view('roles/user_groups', $data);
	}


	public function datatable_roles()
	{
		$this->xhr();
        $results = $this->role_model->fetch_datatable_roles();
        echo json_encode($results);
	}


	public function detail()
	{
		$this->check_permissions( ROLE, 'r' );
		$uri_code = $this->uri->segment(4);
		$detail = $this->role_model->get_role_detail( array('CODE'=>$uri_code), FALSE );
		$this->respond( $detail );
		
		$data = array(
				'page'		=> $this->pagename,
				'header'	=> 'User Groups',
				'menu' 		=> 'accounts',
				'submenu' 	=> 'roles',
				'title'		=> 'User Group <small>DETAIL</small>',
				'detail'	=> $detail,
			);

		$this->get_view('roles/user_groups_detail', $data);
	}
}

/* End of file roles.php */
/* Location: ./modules/account/controllers/roles.php */
?>