<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Main_Control.php');

Class Users extends Main_control
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
	}	

	protected $title = 'Users';

	public function index()
	{
		$data = array(
				'menu' 		=> 'setup',
				'submenu' 	=> 'users',
				'title'		=> $this->title,
				'button'	=> null,
			);

		$this->get_view('users_index', $data);
	} 

	
	public function datatable_users()
	{
        $this->xhr();
        $results = $this->user_model->fetch_datable_users();
        echo json_encode($results);
	}

	//	get single user record
	public function get_user()
	{
		$this->xhr();
		$user_id = $this->input->post('user_id');
        $results = $this->user_model->fetch_user( $user_id );
        echo json_encode($results);
	}

	public function validate_users()
	{
		$this->xhr();
		$post_formdata = $this->input->post();
		$results = null;

		switch ($post_formdata['action']) 
		{
			case 'update':
				$results = $this->user_model->update_user( $post_formdata );
				break;
			
			case 'insert':
			default:
				$results = $this->user_model->insert_user( $post_formdata );
				break;
		}

        echo json_encode($results);
	}

}
