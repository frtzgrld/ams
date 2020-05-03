<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'modules/inventory/models/inventory_model.php' );

Class ARE_Model extends Inventory_Model
{
	function __construct()
    {
        parent::__construct();
    }


    public function index()
    {

    }


    // public function fetch_datable_are()
    // {
    //     $tableset = array(
    //             'object'    => 'VW_SMALL_VALUE',
    //             'index'     => 'ID',
    //             'join'      => null,
    //             'where'     => null,
    //             'group'     => null,
    //             'columns'   => array(
    //                     'CODE',
    //                     'DESCRIPTION',
    //                     'LOTNO',
    //                     "CREATEDDATE",
    //                     'SLUG',
    //                     'ID',
    //                 ),
    //         );

    //     return $this->DataTable( $this->activegroup, $tableset);
    // }
}