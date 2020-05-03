<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'modules/inventory/models/inventory_model.php' );

Class Supplies_Model extends Inventory_Model
{
	function __construct()
    {
        parent::__construct();
    }


    public function index()
    {

    }


    public function fetch_datatable_supplies()
    {
        $tableset = array(
                'object'    => 'VW_INVENTORY_SUPPLIES',
                'index'     => 'ITEMID',
                'join'      => null,
                'where'     => null,
                'group'     => null,
                'columns'   => array(
                        'ITEMS',
                        'QTYONHAND',
                        'UNIT',
                        'MINQTY',
                        'MAXQTY',
                        'QTYSTATUS',
                        'ITEMID',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
    }


    public function fetch_datatable_supplies_history( $item=null )
    {
    	$where = $item ? 'WHERE ITEMID = '.$item : null;

        $tableset = array(
                'object'    => 'VW_INVENTORY_SUPPLIES_HISTORY',
                'index'     => 'SUPPLYID',
                'join'      => null,
                'where'     => $where,
                'group'     => null,
                'columns'   => array(
                        'DATEACQUIRED',
                        'QTYACQUIRED',
                        'UNITCOST',
                        'QTYONHAND',
                        // 'ONQUEUE',
                        // 'USEFUL_FOR',
                        'SUPPLYID',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
    }

    public function fetch_datatable_fastmoving_supplies()
    {
        $tableset = array(
                'object'    => 'ris_items',
                'index'     => 'ris_items.ID',
                'join'      => 'INNER JOIN ris ON ris_items.ris = ris.id
LEFT JOIN items ON items.id = ris_items.`REQ_DESCRIPTION`',
                'where'     => null,
                'group'     => 'GROUP BY items.DESCRIPTION',
                'columns'   => array(
                        'ris_items.REQ_STOCK_NO',
                        'ris_items.REQ_UNIT',
                        'items.DESCRIPTION',
                        'SUM(ris_items.`ISSUED_QTY`) AS total_issued_qty',
                        // 'ris_items.ID',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
    }


    public function save_received_supplies( $input=null )
    {
        $this->db->trans_start();

        for($a=0; $a<count($input['item']); $a++)
        {
            $data = array(
                    'ITEMS'         => $input['item'][$a],
                    'UNIT'          => $this->get_record('ITEMS', 'UNIT', array('ID' => $input['item'][$a])),
                    'UNITCOST'      => $input['unitcost'][$a],
                    'QTYACQUIRED'   => $input['quantity'][$a],
                    'DATEACQUIRED'  => date_format( date_create($input['dateacquired']), 'Y-m-d'),
                    'QTYONHAND'     => $input['quantity'][$a],
                    'SUPPLIER'      => nullable($input['supplier']),
                    'ONQUEUE'       => $this->check_supply_queueing($input['item'][$a]),
                );
        }

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
                $data['CREATEDBY'] = $this->session->userdata('EMPLOYEENO');
                $this->db->insert('SUPPLIES', $data);

                // $this->db->query("UPDATE STOCKS SET NO_OF_STOCKS = NO_OF_STOCKS + ".$input['quantity']." WHERE ITEMS = ".$input['item']);
                break;
        }

        // $redirect = $input['hidden_return_address'] != null ? base_url().$input['hidden_return_address'] : null;

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->commonErrorResponse();
        } else {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success',
                    'header'    => 'SUCCESS',
                    'message'   => 'Supply has been successfully saved.',
                    // 'redirect'  => base_url().'inventory/supplies/acquisitions/'.$input['item'],
                );
        }
    }


    protected function check_supply_queueing( $item_key=null )
    {
        $que_state = $this->get_record('SUPPLIES', 'ONQUEUE', array('ID' => $item_key));

        return ( (int)$que_state == 1 ) ? 0 : 1;
    }
}