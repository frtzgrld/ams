<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class Users_Model extends Home_Model
{
	function __construct()
    {
        parent::__construct();
        
    }

    public function users_list()
    {
        $this->db->select('id, employeeno');
        $this->db->from('users');
        $this->db->where('active', 1);

        return $this->resultArray();
    }

    public function users_office()
    {
        $this->db->select('users.id, users.user_office, offices.description, users.employeeno');
        $this->db->from('users');
        $this->db->join('offices', 'offices.id = users.user_office', 'left');
        $this->db->where('users.user_office', 1);
        $this->db->where('users.active', 1);

        return $this->resultArray();
    }

    public function employee_list()
    {
        // $this->db->from('vw_hrs_employees');
        // $this->db->where('active', 1);

        $this->db->from('VW_USERS');
        $this->db->where("OFFICEID IN ".$this->offices_in_array());
        $this->db->order_by('FULLNAME');

        return $this->resultArray();
    }
}