<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/home_model.php' );

Class File_Model extends Home_Model
{
	function __construct()
    {
        parent::__construct();
    }


    public function options_purchase_request()
    {
        $this->db->select("ID, CONCAT(PR_NO,' (',PURPOSE,')') AS PURCHASE_REQUESTS");
        $this->db->from('PURCHASE_REQUESTS');
        $this->db->where('YEAR(CREATEDDATE)', date('Y'));
        $this->db->where('STATUS', 'APPROVED');

        return $this->resultArray();
    }


    public function options_app()
    {
        $this->db->select("ID, CODE");
        $this->db->from('APP');
        $this->db->where('YEAR(CREATEDDATE)', date('Y'));
        $this->db->where('STATUS', 'APPROVED');

        return $this->resultArray();
    }
}