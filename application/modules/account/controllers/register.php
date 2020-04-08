<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Register extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('role_model');
        $this->load->helper('system_options');
        $this->load->library('form_validation');
	}
}