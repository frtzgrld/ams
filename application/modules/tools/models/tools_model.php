<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class Tools_Model extends Home_Model
{
	function __construct()
    {
        parent::__construct();
    }


    public function save_account_chart( $input=null )
    {
        if( $input && is_array($input) )
        {
            for ($i=1; $i <= count($input); $i++) 
            { 
                $proceed = true;

                if( !is_numeric($input[$i]['B']) && $proceed ) {
                    $description = $input[$i]['B'];
                    $proceed = false;
                }
                
                if( !is_numeric($input[$i]['C']) && $proceed ) {
                    $description = $input[$i]['C'];
                    $proceed = false;
                }

                if( !is_numeric($input[$i]['D']) && $proceed ) {
                    $description = $input[$i]['D'];
                    $proceed = false;
                }

                if( !is_numeric($input[$i]['E']) && $proceed ) {
                    $description = $input[$i]['E'];
                    $proceed = false;
                }

                $data = array(
                        'DESCRIPTION'   => $description
                    );

                $this->db->insert('ACCOUNTS_LIST', $data);
                $account_list_id = $this->db->insert_id();

                $dataset = array(
                        'ACCOUNTS_LIST' => $account_list_id,
                        'ACCOUNTS'      => $description,
                        'SEGMENT1'      => $input[$i]['A'],
                        'SEGMENT2'      => is_numeric($input[$i]['B']) ? $input[$i]['B'] : NULL,
                        'SEGMENT3'      => is_numeric($input[$i]['C']) ? $input[$i]['C'] : NULL,
                        'SEGMENT4'      => is_numeric($input[$i]['D']) ? $input[$i]['D'] : NULL,
                    );

                $this->db->insert('ACCOUNTS_CHART', $dataset);
            }

            return 'SUCCESS';
        }
    }
}