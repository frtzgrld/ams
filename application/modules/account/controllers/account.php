<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'controllers/Main_Control.php' );

Class Account extends Main_Control 
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
		$this->load->model('authentication_model');
		
		define('ACC', 'account');
	}

	protected $pagename = 'ACCOUNT';

	public function index()
	{
		$this->login();
	}

	public function checklog()
	{
		return;
	}

	public function login()
	{
		$this->session->sess_destroy();
		$this->load->view('system_login');
	}

	//	Method to validate form data submitted from views/newslist
	public function validate_form_login()
	{
		if( $this->form_validation->run('system_login') === TRUE )
		{
			
			$this->verify_credentials($this->input->post());
		}
		else
		{
			$errors = array(
				'errors'	=>	validation_errors(),
			);

			$this->output->set_output(print(json_encode($errors)));
			exit();
		}
	}

	//	Method to check record from the db
   	protected function verify_credentials( $data=array() )
   	{
		$output = $this->authentication_model->validate_system_login($data['username'], $data['password']);
		header("Content-Type: application/json", true);
		$this->output->set_output(print(json_encode($output)));
		exit();
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
?>
