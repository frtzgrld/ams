<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Main_Control.php');

Class Offices extends Main_Control {

	function __construct() 
	{
		// parent::__construct();
		// $this->load->model('ppmp/ppmp_model');
		$this->load->model('office_model');

	}

	protected $title = 'Offices and its Supplies/Properties';

	public function index()
	{
		if(isset($_POST['action'])){
			$output = $this->office_model->crud_office($_POST);
			$this->output->set_output(print(json_encode($output)));
			exit();
		}

		$data = array(
				'menu' 		=> 'setup',
				'submenu' 	=> 'offices',
				'title'		=> 'Offices',
				// 'offices'	=> $this->office_model->office_in_hierarchy(),
				// 'ppmp_procedures'	=> $this->ppmp_model->procedures_list(),
			);

		$this->get_view(array('office_modal','offices_index'), $data);
	}

	public function datatable_offices()
	{
        $this->xhr();
        $results = $this->office_model->fetch_datable_offices();
        echo json_encode($results);
	}

	public function office_detail()
	{
		// $this->load->module('items');

		// $this->items->index();

		$url_office_code = $this->uri->segment(3); 

		$this->respond($url_office_code); 
		$offices_detail = $this->office_model->get_office_detail( 'o.CODE', $url_office_code, TRUE );
		$this->respond( $offices_detail );

		$data = array(
				'menu' 		=> 'setup',
				'submenu' 	=> 'offices',
				'title'		=> 'Offices',
				'detail'	=> $offices_detail,
				'offices'	=> $this->office_model->office_list(),
			);
		
		$this->get_view(array('office_modal','offices_detail'), $data);
	}


	public function load_office()
	{
        $this->xhr();
        $post_office_id = $this->input->post('office_id');
        $results = $this->office_model->get_office_detail( 'O.ID', $post_office_id );
        echo json_encode($results);
	}


	public function validate_office()
	{
		$this->xhr();
        $post_formdata = $this->input->post();

        switch ($post_formdata['action']) {
        	case 'update':
        		$results = $this->office_model->update_office($post_formdata);
        		break;

        	case 'insert':
        	default:
        		$results = $this->office_model->insert_office($post_formdata);
        		break;
        }
        
        echo json_encode($results);
	}


	public function responsibility_center()
	{
		$data = array(
				'menu' 		=> 'setup',
				'submenu' 	=> 'offices',
				'title'		=> 'Offices',
				'offices'	=> $this->office_model->responsibility_center(),
			);

		$this->get_view('responsibility_center', $data);
	}


	public function unique_office_code()
	{
        $this->xhr();
        $post_office_code = $this->input->post('office_code');
        $post_office_id = $this->input->post('office_id');
        $results = $this->office_model->verify_unique_office_code($post_office_code, $post_office_id);
        echo json_encode($results);
	}


	public function unique_office_acronym()
	{
        $this->xhr();
        $post_office_acronym = $this->input->post('office_acronym');
        $post_office_id = $this->input->post('office_id');
        $results = $this->office_model->verify_unique_office_acronym($post_office_acronym, $post_office_id);
        echo json_encode($results);
	}


	public function heads()
	{
		$data = array(
				'menu' 		=> 'setup',
				'submenu' 	=> 'offices',
				'title'		=> 'Office/Department Heads',
				'office_heads'		=> $this->office_model->get_office_heads(),
				// 'ppmp_procedures'	=> $this->ppmp_model->procedures_list(),
			);

		$this->get_view(array('offices_heads'), $data);
	}


	public function validate_office_heads()
	{
        $this->xhr();
        $post_formdata = $this->input->post();
        $results = $this->office_model->save_office_heads($post_formdata);
        echo json_encode($results);
	}


	public function validate_document_sign()
	{
        $this->xhr();
        $post_formdata = $this->input->post();
        $results = $this->office_model->save_document_sign($post_formdata);
        echo json_encode($results);
	}

	public function delete_office()
	{
		$this->xhr();
		$officeid = $this->input->post('user_office_id');
		// $results = $this->office_model->delete_office($officeid);
		// echo json_encode($results);

		$output = $this->office_model->delete_office($officeid);
			$this->output->set_output(print(json_encode($output)));
			exit();
	}
}
