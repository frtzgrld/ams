<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Home.php');

Class Transfer extends Home {

	function __construct() 
	{
		parent::__construct();

		// $this->load->model('distribution_model');
	}


    protected $title = 'Transfer';
    protected $submenu = 'transfer';


    public function index()
    {
        $data = array(
                'menu'      => $this->module,
                'submenu'   => $this->submenu,
                'title'     => $this->title,
            );

        $this->get_view('ditribution_index', $data);
    }
	

	public function datatable_transfer_history()
	{
        $this->xhr();
        $item = $this->uri->segment(4);
        // $results = $this->distribution_model->fetch_datatable_distrib_history($item );
        echo json_encode($results);
	}
}
