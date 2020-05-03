<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Home.php');

Class Inventory extends Home {

	function __construct() 
	{
		parent::__construct();

		$this->load->model('inventory_model');
		$this->load->model('delivery/delivery_model');
	}


	protected $module = 'inventory';


	public function index()
	{

	}
	

	public function validate_disposal($input=null)
	{
		$this->xhr();
        $results = $this->inventory_model->manage_disposal( $this->input->post() );
        echo json_encode($results);
	}


	public function stocks()
	{
		$received = $this->delivery_model->get_delivery_detail( array('D.ID'=>$this->uri->segment(3)), TRUE );
		$this->respond($received);

		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> NULL,
				'title'		=> 'Save Stock',
				'received'	=> $received,
				'collapse'	=> false,
			);

		$this->get_view('in_stock', $data);
	}
	

	public function validate_received_stocks($input=null)
	{
		$this->xhr();
        $results = $this->inventory_model->manage_received_stocks( $this->input->post() );
        echo json_encode($results);
	}
}