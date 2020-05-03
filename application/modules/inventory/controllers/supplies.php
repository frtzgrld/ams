<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'modules/inventory/controllers/inventory.php');

Class Supplies extends Inventory {

	function __construct()
	{
		parent::__construct();

		$this->load->model('supplies_model');
	}


	protected $title = 'Supplies';

	protected $submenu = 'supplies';


	public function index()
	{
		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title,
			);

		$this->get_view(array('supplies/supplies_index'), $data);
	}


	public function datatable_supplies()
	{
        $this->xhr();
        $results = $this->supplies_model->fetch_datatable_supplies();
        echo json_encode($results);
	}


	public function acquisitions()
	{
		$supply_id = $this->uri->segment(4);
		$supply = $this->inventory_model->get_acquisition_detail('supply', $supply_id);
		$this->respond( $supply );

		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title,
				'supply'	=> $supply
			);

		$this->get_view('supplies/supplies_detail', $data);
	}


	public function datatable_supply_history()
	{
        $this->xhr();
        $item = $this->uri->segment(4);
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

}