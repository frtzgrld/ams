<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH.'controllers/Main_Control.php');

Class items extends Main_Control
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('items_model');
		// $this->load->model('ppmp/ppmp_model');
	}

	protected $title = 'Items';
	
	public function index()
	{
		if(isset($_POST['action'])){
			$output = $this->items_model->crud_item($_POST);
			$this->output->set_output(print(json_encode($output)));
			exit();
		}

		$data = array(
				'menu' 		=> 'setup',
				'submenu' 	=> 'items',
				'title'		=> $this->title,
				'button'	=> null,
				'items'		=> $this->items_model->get_options_items(),
			);

		$this->get_view(array('item_modal','items_index'), $data);
	}

	public function datatable_items()
	{
        $this->xhr();
		$results = $this->items_model->fetch_datable_items();
		// var_dump($results);
		// exit();
        echo json_encode($results);
	}


	public function load_item()
	{
		$this->xhr();
        $results = $this->items_model->get_item( $this->input->post('item_id') );
        echo json_encode($results);
	}

	public function __items_create()
	{
		$codeprefx = 'ITM';
		$code = $this->ppmp_model->create_code($codeprefx, 'items');
		
		$this->db->insert('items', array('code' => $code, 'parent'	=> $this->input->post('parent'),'description'	=> $this->input->post('description'),'unit'	=>	$this->input->post('unit'), 'category'	=> $this->input->post('category')));
		redirect('items/index');

	}


	public function validate_item()
	{
		$this->xhr();
		$post_formdata = $this->input->post();
        $results = $this->items_model->manage_items( $post_formdata );
        echo json_encode($results);
	}


	public function items_detail()
	{
		$item_id = $this->uri->segment(3);
		$item_detail = $this->items_model->get_item_detail('i.ID', $item_id, TRUE);
		
		$data = array(
				'menu' 		=> 'setup',
				'submenu' 	=> 'items',
				'title'		=> $this->title,
				'button'	=> null,
				'itemdetail'=> $item_detail,
				'items'		=> $this->items_model->get_options_items(),
			);
		// var_dump($data['itemdetail']);
		// echo profile('EMPLOYEENO', $item_detail['CREATEDBY'], 'LASTNAME');
		// exit();
		$this->get_view(array('item_modal','items_detail'), $data);
	}

	public function items_update_record()
	{
		$id = $this->uri->segment(3);
		$data = array(
			'category'	=> $_POST['category'],
			'parent'	=> $_POST['parent'],
			'description'	=> $_POST['description'],
			'unit'	=> $_POST['unit'],
			);
		$this->db->where('id', $id);
		$this->db->update('items', $data);
		redirect('items/index');
	}


	public function get_items()
	{
		$this->xhr();
		$post_category = $this->input->post('category');
		$post_leafonly = $this->input->post('leafonly');
		$post_itemid = $this->input->post('itemid');
        $results = $this->items_model->get_options_items( $post_category, $post_leafonly, $post_itemid );
        echo json_encode($results);
	}
}
