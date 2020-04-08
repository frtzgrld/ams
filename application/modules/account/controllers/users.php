<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'controllers/Main_Control.php' );

Class Users extends Main_Control 
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('role_model');
		$this->load->model('user_model');
	}

	protected $title = 'Account Management';

	public function index()
	{
		if(isset($_POST['action'])){
			$output = $this->user_model->crud_users($_POST);
			$this->output->set_output(print(json_encode($output)));
			exit();
		}

		$data = array(
				'title'			=> $this->title.' <small>USER ACCOUNTS</small>',
				'menu' 			=> 'accounts',
				'submenu' 		=> 'users',
				'employees'		=> $this->user_model->get_employee_list(),
				'user_groups'	=> $this->role_model->fetch_user_groups(),
				'offices'		=> $this->user_model->office_list(),
			);
		// die(var_dump($data['employees']));
		$this->get_view(array('users/users_index'), $data);
	}


	public function datatable_users()
	{
		// $permissions = $this->check_permissions( USER );
        $results = $this->user_model->fetch_datable_offices();
        echo json_encode($results);
	}


	public function user_detail()
	{
		$url_user_id = $this->uri->segment(4);
		$user_detail = $this->user_model->fetch_user_detail( $url_user_id, TRUE );
		$this->respond($user_detail);

		$data = array(
				'menu' 		=> 'accounts',
				'submenu' 	=> 'users',
				'title'		=> $this->title,
				'user_info'	=> $user_detail,
				'employees'		=> $this->user_model->get_employee_list(),
				'user_groups'	=> $this->role_model->fetch_user_groups(),
				'offices'		=> $this->user_model->office_list(),
			);
		
		var_dump($data['user_info']);
		exit();
		$this->get_view(array('users/users_modal','users/account_detail'), $data);
	}


	public function validate_users()
	{
		$this->xhr();
		$results = $this->user_model->manage_user_account( $this->input->post() );
        echo json_encode($results);
	}

	public function validate_users_update()
	{
		$this->xhr();
		$results = $this->user_model->update_user_account( $this->input->post() );
        echo json_encode($results);
	}

	//	single user record
	public function get_user_detail()
	{
		$this->xhr();
        $results = $this->user_model->fetch_user_detail( $this->input->post('user_id') );
        echo json_encode($results);
	}

	//	for select option
	public function get_user_list()
	{
		$this->xhr();
        $results = $this->user_model->get_employee_list( $this->input->post() );
        echo json_encode($results);
	}

	public function remove_user_office()
	{
		$this->xhr();
        $results = $this->user_model->remove_user_office( $this->input->post('user_office_id') );
        echo json_encode($results);
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
?>
