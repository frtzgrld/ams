<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'controllers/Main_Control.php' );

/**
 |  Home.php
 |  This serves as the landing page for every role based controllers after login
 |  
 |  
 */
Class home extends main_control 
{
    var $sheet;
    
	function __construct()
    {
        parent::__construct();

        $this->checklog();

        $this->load->model('home_model');
        $this->load->model('offices/office_model');
        $this->load->model('items/items_model');
        
        $this->load->library('excel');

        $this->sheet = $this->excel->getActiveSheet();
    }


    function index()
    {
        // $this->load->model('tools/activity_model');

        $data = array(
                'menu'      => 'dashboard',
                'submenu'   => null,
                'title'     => 'Dashboard',
                // 'today'     => $this->activity_model->calendar_of_activities(date('Y'),date('m'),date('d')),
            );

        $this->get_view('dashboard', $data);
    }


    public function get_value()
    {
        $this->xhr();
        $post_table = $this->input->post('table');
        $post_target = $this->input->post('target');
        $post_column = $this->input->post('column');
        $post_values = $this->input->post('values');
        $results = $this->home_model->fetch_value( $post_table, $post_target, $post_column, $post_values );
        echo json_encode($results);
        exit();
    }
}
