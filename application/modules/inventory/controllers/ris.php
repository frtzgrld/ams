<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'modules/inventory/controllers/inventory.php');

Class RIS extends Inventory {

	function __construct()
	{
		parent::__construct();

		$this->load->model('ris_model');
	}


	protected $title = 'Request and Issue Slip';


	public function index()
	{
		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> 'ris',
				'title'		=> $this->title,
			);

		$this->get_view('ris/ris_index', $data);
	}

}