<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'modules/inventory/controllers/inventory.php');

Class Property_and_Equipment extends Inventory {

	function __construct()
	{
		parent::__construct();

		$this->load->model('properties_model');

		// $this->get_service_unavailable();
	}


	protected $title = 'Property';

	protected $submenu = 'prop_equip';


	public function index()
	{
		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title,
			);

		$this->get_view(array('property_disposal_modal','properties/properties_index'), $data);
	}


	public function datatable_properties()
	{
        $this->xhr();
        $results = $this->properties_model->fetch_datatable_properties();
        echo json_encode($results);
	}


	public function acquisitions()
	{
		$property_id = $this->uri->segment(4);
		$property = $this->inventory_model->get_acquisition_detail('property', $property_id);
		$this->respond( $property );

		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> $this->submenu,
				'title'		=> $this->title,
				'property'	=> $property
			);

		$this->get_view('properties/properties_detail', $data);
	}


	public function datatable_supply_history()
	{
        $this->xhr();
        $item = $this->uri->segment(4);
        $results = $this->properties_model->fetch_datatable_properties_history( $item );
        echo json_encode($results);
	}


	//	Receive (insert new) supply
	public function receive()
	{
		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> $this->submenu,
				'title'		=> 'Receive Property',
				'items'		=> $this->items_model->get_options_items('property', TRUE),
			);

		$this->get_view('properties/receive_property', $data);
	}


	public function validate_received_properties()
	{
        $this->xhr();
        $post_formdata = $this->input->post();
        $results = $this->properties_model->save_received_properties( $post_formdata );
        echo json_encode($results);
	}


	public function get_property_nos()
	{
		$this->xhr();
        $post_itemid = $this->input->post('itemid');
        $post_status = $this->input->post('status');
        $results = $this->properties_model->fetch_property_nos( $post_itemid, $post_status );
        echo json_encode($results);
	}
}
