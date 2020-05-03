<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Home.php');

Class Distribution extends Home {

	function __construct() 
	{
		$this->load->model('distribution_model');
	}

    protected $title = 'Distribution';
    protected $module = 'dist';
    protected $submenu = null;

    public function index()
    {
        $this->property();
    }

    public function property()
    {
        $data = array(
                'menu'      => $this->module,
                'submenu'   => $this->submenu,
                'title'     => $this->title,
                'properties'=> $this->items_model->get_options_items('property', TRUE),
                'employees' => $this->users_model->employee_list(),
                'offices'   => $this->office_model->office_list(),
            );

        $this->get_view('distribution_index', $data);
    }
	

	public function datatable_distrib_history()
	{
        $this->xhr();
        $item = $this->uri->segment(3);
        $results = $this->distribution_model->fetch_datatable_distrib_history($item );
        echo json_encode($results);
	}


    public function datatable_property_distrib_history()
    {
        $this->xhr();
        $item = $this->uri->segment(3);
        $results = $this->distribution_model->fetch_datatable_property_distrib_history($item );
        echo json_encode($results);
    }


    public function supply()
    {
        $data = array(
                'menu'      => $this->module,
                'submenu'   => 'dist_supp',
                'title'     => $this->title,
                'items'     => $this->items_model->get_options_items('supply'),
                'office'    => $this->office_model->office_list(),
            );

        $this->get_view('distribute_supply', $data);
    }


    public function validate_issuance_of_supply()
    {
        $this->xhr();
        $post_formdata = $this->input->post();
        $results = $this->distribution_model->save_issuance_of_supply( $post_formdata );
        echo json_encode($results);
    }

    public function validate_distribution_of_property()
    {
        $this->xhr();
        $post_formdata = $this->input->post();
        $results = $this->distribution_model->save_distribution_of_property( $post_formdata );
        echo json_encode($results);
    }
}
