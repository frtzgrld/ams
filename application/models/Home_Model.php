<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Main_Model.php' );

Class Home_Model extends Main_Model
{
	function __construct()
    {
        parent::__construct();
    }


    protected function offices_in_array()
    {
    	$offices = $this->session->userdata('USER_OFFICES');
        
    	if( $offices )
    	{
    		$offices_in_array = '(';

    		foreach ($offices as $row) {
    			$offices_in_array .= $row['OFFICES'].",";
    		}

    		return rtrim($offices_in_array,',').")";
    	}

    	return null;
    }


    protected function common_failure_response()
    {
        return array(
                    'result'    => 'error',
                    'header'    => 'FAILED',
                    'message'   => 'The system cannot process your request.',
                );
    }
    

    public function fetch_value($table=null, $target_column=null, $where_column=null, $where_value=null )
    {
        $this->db->select($target_column)->from($table)->where($where_column, $where_value);

        return array('result' => $this->resultRow($target_column));
    }


    protected function transaction_id($module='PS')
    {
        return date_format(date_create(date('Y-m-d h:i:s')),'Ymdhis').$module.$this->session->userdata('USERID');
    }


}
