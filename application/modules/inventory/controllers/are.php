<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'modules/inventory/controllers/inventory.php');

Class ARE extends Inventory {

	function __construct()
	{
		parent::__construct();

		$this->load->model('are_model');
	}


	protected $title = 'Acknowledgement Receipt for Equipment';


	public function index()
	{
		$data = array(
				'menu' 		=> $this->module,
				'submenu' 	=> 'are',
				'title'		=> $this->title,
			);

		$this->get_view('are/are_index', $data);
	}

}