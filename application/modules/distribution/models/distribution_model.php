<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/home_model.php' );

Class Distribution_Model extends Home_Model
{
	function __construct()
    {
        parent::__construct();
    }


    public function fetch_datatable_property_distrib_history( $item=null )
    {
        $where = $item ? 'WHERE ITEMID = '.$item : null;

        $tableset = array(
                'object'    => 'VW_DISTRIBUTION_HISTORY',
                'index'     => 'DISTRIBID',
                'join'      => null,
                'where'     => $where,
                'group'     => null,
                'columns'   => array(
                        'ASSIGNED_TO',
                        'PROPERTYNO',
                        'ASSIGNED_DATE',
                        'ASSIGNED_BY',
                        'ASSIGNED_STATUS',
                        'DISTRIBID',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
    }


    public function fetch_datatable_distrib_history( $item=null )
    {
        $where = $item ? 'WHERE ris_items.REQ_DESCRIPTION = '.$item : null;

        $tableset = array(
                'object'    => 'ris_items',
                'index'     => 'ID',
                'join'      => 'LEFT JOIN ris ON ris.id = ris_items.ris
                LEFT JOIN offices ON offices.id = ris.`OFFICES`
                LEFT JOIN items ON items.id = ris_items.`REQ_DESCRIPTION`',
                'where'     => $where,
                'group'     => null,
                'columns'   => array(
                        'OFFICES.DESCRIPTION',
                        'RIS_ITEMS.ISSUED_QTY',
                        'RIS.CREATEDDATE',
                        'RIS.ISSUED_BY',
                        'RIS.ID',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
    }


    public function save_issuance_of_supply( $input=null )
    {
        $this->db->trans_start();
        
        $data = array(
                'ITEMS'             => $input['item'],
                'ITEM_DESCRIPTION'  => $this->get_record('ITEMS', 'DESCRIPTION', array('ID' => $input['item'])),
                'ASSIGNED_QTY'      => $input['quantity'],
                'ASSIGNED_TO_OFFICE'=> $input['office'],
                'ASSIGNED_DATE'     => date_format( date_create($input['dateissued']), 'Y-m-d h:i:s' ),
                'ASSIGNED_STATUS'   => 'current use',
            );

        switch( $input['hidden_action'] )
        {
            case 'update':
                // $data['MODIFIEDBY'] = $this->session->userdata('EMPLOYEENO');
                // $data['MODIFIEDDATE'] = date('Y-m-d h:i:s');
                // $this->db->where('ID', $input['hidden_supply_id']);
                // $this->db->update('QUOTATIONS', $data);
                break;

            case 'insert':
            default:
                $data['ASSIGNED_BY'] = $this->session->userdata('EMPLOYEENO');
                $this->db->insert('DISTRIBUTION', $data);
                // print_r($data);
                break;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->commonErrorResponse();
        } else {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success',
                    'header'    => 'SUCCESS',
                    'message'   => 'Record of issuance of supply has been successfully saved.',
                );
        }
    }


    public function save_distribution_of_property( $input )
    {
        $this->db->trans_start();
        
        $data = array(
                'ITEMS'             => $input['property'],
                'ITEM_DESCRIPTION'  => $this->get_record('ITEMS', 'DESCRIPTION', array('ID' => $input['property'])),
                'PROPERTYNO'        => $input['propertyno'],
                'ASSIGNED_QTY'      => $input['quantity'],
                'ASSIGNED_TO_PERSON'=> $input['assignedto'],
                'ASSIGNED_TO_OFFICE'=> $input['office'],
                'ASSIGNED_DATE'     => date_format( date_create($input['assigneddate']), 'Y-m-d h:i:s' ),
                'ASSIGNED_STATUS'   => 'serviceable',
            );

        switch( $input['hidden_action'] )
        {
            case 'update':
                break;

            case 'insert':
            default:
                $data['ASSIGNED_BY'] = $this->session->userdata('EMPLOYEENO');
                $this->db->insert('DISTRIBUTION', $data);
                break;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->commonErrorResponse();
        } else {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success',
                    'header'    => 'SUCCESS',
                    'message'   => 'Distribution of property has been saved.',
                );
        }
    }
}