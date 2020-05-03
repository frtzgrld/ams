<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'modules/inventory/models/inventory_model.php' );

Class Properties_Model extends Inventory_Model
{
	function __construct()
    {
        parent::__construct();
    }


    public function index()
    {

    }


    public function fetch_datatable_properties()
    {
        $tableset = array(
                'object'    => 'properties',
                'index'     => 'ID',
                'join'      => null,
                'where'     => null,
                'group'     => null,
                'columns'   => array(
                        'PROPERTYNO',
                        'DESCRIPTION',
                        'CATEGORY',
                        'ID',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
    }


    public function fetch_datatable_properties_history( $item=null )
    {
    	$where = $item ? 'WHERE ITEMID = '.$item : null;

        $tableset = array(
                'object'    => 'VW_INVENTORY_PROPERTIES_HISTORY',
                'index'     => 'SUPPLYID',
                'join'      => null,
                'where'     => $where,
                'group'     => null,
                'columns'   => array(
                        'DATEACQUIRED',
                        'QTYACQUIRED',
                        'UNITCOST',
                        'QTYONHAND',
                        'USEFUL_FOR',
                        'SUPPLYID',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
    }


    public function save_received_properties( $input=null )
    {
        $this->db->trans_start();
        
        $data = array(
                'PROPERTYNO'    => $input['propertyno'],
                'SERIALNO'      => $input['serialno'],
                'ITEMS'         => $input['item'],
                'CATEGORY'      => $input['property_category'],
                'DESCRIPTION'   => $this->get_record('ITEMS','DESCRIPTION',array('ID'=>$input['item'])),
                'MODEL'         => $input['model'],
                'DATEACQUIRED'  => date_format( date_create($input['dateacquired']), 'Y-m-d'),
                'UNITCOST'      => $input['unitcost'],
                'QTYONHAND'     => $input['quantity'],
                'EST_USEFUL_LIFE'   => $input['useful_life'],
                'EUL_UNIT'      => $input['eul_unit'],
                'ONQUEUE'       => 1, //$this->check_supply_queueing($input['item']),
            );

        // print_r($data); die();
        switch( $input['hidden_action'] )
        {
            case 'update':
                break;

            case 'insert':
            default:
                $data['CREATEDBY'] = $this->session->userdata('EMPLOYEENO');
                $this->db->insert('properties', $data);
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
                    'message'   => 'Property/Plant/Equipment has been successfully saved.',
                    'redirect'  => base_url().'inventory/property_and_equipment/acquisitions/'.$input['item'],
                );
        }
    }


    public function fetch_property_nos( $itemid=null, $status=null )
    {
        $this->db->select("P.PROPERTYNO, E.FULLNAME AS ASSIGNEDTO");
        $this->db->from('PROPERTIES P ');
        $this->db->join('DISTRIBUTION D', 'D.PROPERTYNO = P.PROPERTYNO AND D.ITEMS = P.ITEMS', 'LEFT');
        $this->db->join('VW_HRS_EMPLOYEES E', 'E.EMPLOYEE_NO = D.ASSIGNED_TO_PERSON', 'LEFT');
        $this->db->where('P.ITEMS', $itemid);
        $this->db->where('P.PROPERTYNO NOT IN (SELECT PROPERTYNO FROM DISPOSAL WHERE PROPERTYNO IS NOT NULL)');

        switch( $status )
        {
            case 'free': $this->db->where('D.PROPERTYNO IS NULL'); break;
            case 'assigned': $this->db->where('D.PROPERTYNO IS NOT NULL'); break;
            default: break;
        }

        $this->db->order_by('P.PROPERTYNO');

        return $this->resultArray();
    }
}
