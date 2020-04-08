<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/home.php');

class File extends Home {

	function __construct()
	{
		parent::__construct();
        
        $this->load->model('file_model');
	}


	protected $title = 'File';
	protected $menu = 'file';


	public function index()
	{
		
	}

}