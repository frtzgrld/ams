<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Main_Control.php');

Class Tools extends Main_control
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('tools_model');
	}	

	protected $title = 'Tools';

	public function index()
	{
		$data = array(
				'menu' 		=> 'dashboard',
				'submenu' 	=> '',
				'title'		=> $this->title,
				'button'	=> null,
			);

		$this->get_view('tools_index', $data);
	}

	public function excel_migrator()
	{
		require_once APPPATH.'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';

		$inputFileName = ASSPATH.'filesource/revised_chart_of_accounts.xls';
		$objReader = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $objReader->load($inputFileName);
		$sheetdata = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		$data = array(
				'title'			=> 'TOOLS',
				'header'		=> 'Excel Data',
				'menu'			=> NULL,
				'submenu' 		=> NULL,
				'sheetdata'		=> 'DONE', // $this->tools_model->save_account_chart( $sheetdata ),
			);

		$this->get_view('excel_data', $data);
	}
}