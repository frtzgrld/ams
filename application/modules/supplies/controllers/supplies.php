<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Main_Control.php');

Class Supplies extends Main_Control {

	function __construct()
	{
		$this->load->model('supplies_model');
		$this->load->model('properties_and_equipment/properties_model');
	}

	protected $title = 'Supplies';
	protected $submenu = 'supplies';
	protected $module = 'inventory';

	public function index()
	{
		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title,
				'item_list' => $this->supplies_model->item_list()
			);

		$this->get_view(array('supplies_modal','supplies_index'), $data);
	}


	public function datatable_supplies()
	{
        $this->xhr();
        $results = $this->supplies_model->fetch_datatable_supplies();
        echo json_encode($results);
	}


	public function acquisitions()
	{
		$supply_id = $this->uri->segment(3);
		
		$supply = $this->supplies_model->get_acquisition_detail('supply', $supply_id);
		$this->respond( $supply );

		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title,
				'supply'	=> $supply,
				'item_list' => $this->supplies_model->item_list()
			);

		$this->get_view(array('supplies_modal','supplies_detail'), $data);
	}


	public function datatable_supply_history()
	{
        $this->xhr();
        $item = $this->uri->segment(3);
        $results = $this->supplies_model->fetch_datatable_supplies_history( $item );
        echo json_encode($results);
	}


	//	Receive (insert new) supply
	public function receive()
	{
		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> $this->submenu,
				'title'		=> 'Receive Supply',
				'items'		=> $this->items_model->get_options_items('supply', TRUE),
			);

		$this->get_view('supplies/receive_supply', $data);
	}


	public function validate_received_supplies()
	{
        $this->xhr();
        $post_formdata = $this->input->post();
        $results = $this->supplies_model->save_received_supplies( $post_formdata );
        echo json_encode($results);
	}

	public function datatable_fastmoving_supplies()
	{
		 $this->xhr();
        // $item = $this->uri->segment(4);
        $results = $this->supplies_model->fetch_datatable_fastmoving_supplies();
        echo json_encode($results);
	}

	public function fastmoving_supplies()
	{
		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> $this->submenu,
				'title'		=> 'Fast Moving Supplies',
				// 'items'		=> $this->items_model->get_options_items('supply', TRUE),
			);

		$this->get_view('supplies/supplies_fast_moving', $data);
	}

	public function datatable_distrib_history()
	{
        $this->xhr();
        $item = $this->uri->segment(3);
        $results = $this->supplies_model->fetch_datatable_distrib_history($item );
        echo json_encode($results);
	}

	public function validate_supplies()
	{
		$this->xhr();
		$post_formdata = $this->input->post();
		$item = $this->uri->segment(3);
        $results = $this->supplies_model->manage_supplies( $post_formdata , $item );
        echo json_encode($results);
	}

	public function load_supp()
	{
		$this->xhr();
        $results = $this->supplies_model->get_supplies( $this->input->post('supphist_id') );
        echo json_encode($results);
	}

}
