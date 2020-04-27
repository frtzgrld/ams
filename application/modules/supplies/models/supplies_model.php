<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class Supplies_Model extends Home_Model
{
	function __construct()
    {
        parent::__construct();
    }

    public function fetch_datatable_supplies()
    {
        $tableset = array(
                'object'    => 'supplies',
                'index'     => 'ITEMS',
                'join'      => 'left join items on items.ID = supplies.items',
                'where'     => 'where items.category = "supply" ',
                'group'     => 'group by items',
                'columns'   => array(
                        'DESCRIPTION',
                        'unit',
                        'minqty',
                        'maxqty',
                        'SUM(qtyonhand)',
						'items',
						'items.id'
                    ),
            );
		$aggregate = "DISTINCT";
        return $this->DataTable( $this->activegroup, $tableset, $aggregate);
    }


    public function fetch_datatable_supplies_history( $item=null )
    {
		
    	$where = $item ? 'WHERE ACTIVE = 1 AND ITEMS = '.$item : null;
		
        $tableset = array(
                'object'    => 'supplies',
                'index'     => 'ID',
                'join'      => null,
                'where'     => $where,
                'group'     => null,
                'columns'   => array(
                        'DATEACQUIRED',
                        'QTYACQUIRED',
                        'UNITCOST',
                        'QTYONHAND',
                        'ONQUEUE',
                        // 'USEFUL_FOR',
                        'ID',
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
	
	public function get_acquisition_detail( $category=null, $identity=null, $child=false )
    {
		$items = "";
        switch( $category )
        {
			case 'supply':
			
				$this->db->select('items.id, items.DESCRIPTION, items.unit, items.minqty , items.maxqty, SUM(supplies.QTYONHAND) as qty');
				$this->db->from('supplies');
				$this->db->join('items', 'items.ID = supplies.items', 'LEFT');
				$this->db->where('items.CATEGORY = "supply" ');
				$this->db->where('items.id', $identity);
				$this->db->group_by('items.id');

				$items = $this->resultArray();
				
                // $items = $this->db->get_where('VW_INVENTORY_SUPPLIES', array('ITEMID' => $identity));
                break;

            case 'property':
                $items = $this->db->get_where('VW_INVENTORY_PROPERTIES', array('ITEMID' => $identity));
                break;
        }
    	// var_dump($items);
		// 		exit();
    	// $result = $this->resultArray($items);
        // print_r($result);
        // exit();

    	// if( $child )
    	// {
	    // 	$data = array(
	    //             array(
	    //                     'index' => 'RECEIVED',
	    //                     'value' => $this->get_acquisition_items( $identity ),
	    //                 ),
	    //             );

	    //     return $this->resultArrayAppend( $result, $data );
	    // }

	    return $items;
	}
	
	public function fetch_datatable_distrib_history( $item=null )
    {
        $where = $item ? 'WHERE ISSUED_QTY IS NOT NULL  AND ris_items.REQ_DESCRIPTION = '.$item : null;

        $tableset = array(
                'object'    => 'ris_items',
                'index'     => 'ris_items.ID',
                'join'      => 'LEFT JOIN ris ON ris.id = ris_items.ris
                LEFT JOIN offices ON offices.id = ris.`OFFICES`
                LEFT JOIN items ON items.id = ris_items.`REQ_DESCRIPTION`',
                'where'     => $where,
                'group'     => null,
                'columns'   => array(
                        'offices.DESCRIPTION',
                        'ris_items.ISSUED_QTY',
                        'ris.ISSUED_DATE',
                        'ris.ISSUED_BY',
                        'ris.ID',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
	}
	
	public function manage_supplies( $input=null )
    {
        $this->db->trans_start();
		if($input['action'] != 'delete' and $input['action'] != 'onqueue' ){
			$data = $this->assign_data_supplies( $input );
		}

		
        
        switch( $input['action'] )
        {
        	case 'update':
        		$data['MODIFIEDBY']	= $this->session->userdata('EMPLOYEENO');
        		$data['MODIFIEDDATE'] = date('Y-m-d h:i:s');

        		$this->db->where('ID', $input['hidden_supp_id']);
        		$this->db->update('supplies', $data);

        		$redirect_id = $input['hidden_supp_id'];
				break;
				
			case 'delete':
				$data['MODIFIEDBY']	= $this->session->userdata('EMPLOYEENO');
				$data['MODIFIEDDATE'] = date('Y-m-d h:i:s');
				$data['ACTIVE'] = 0;

				$this->db->where('ID', $input['supp_id']);
				$this->db->update('supplies', $data);

				$redirect_id = $input['supp_id'];
				break;
			
			case 'onqueue':
				$sups = $this->get_onqueue($input['item']);
				
				if($sups){
					$data['MODIFIEDBY']	= $this->session->userdata('EMPLOYEENO');
					$data['MODIFIEDDATE'] = date('Y-m-d h:i:s');
					$data['ONQUEUE'] = 0;

					$this->db->where('ID', $sups[0]['ID']);
					$this->db->update('supplies', $data);
				}

				$data['MODIFIEDBY']	= $this->session->userdata('EMPLOYEENO');
				$data['MODIFIEDDATE'] = date('Y-m-d h:i:s');
				$data['ONQUEUE'] = 1;

				$this->db->where('ID', $input['supp_id']);
				$this->db->update('supplies', $data);

				$redirect_id = $input['supp_id'];

				
				break;

        	case 'insert':
        	default:
        		$data['CREATEDBY']	= $this->session->userdata('EMPLOYEENO');
        		$data['CREATEDDATE'] = date('Y-m-d h:i:s');

        		$this->db->insert('supplies', $data);
        		$redirect_id = $this->db->insert_id();

        		break;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->common_failure_response();
        } else {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success',
                    'header'    => 'SUCCESS',
                    'message'   => 'Supplies has been successfully updated.',
                    'redirect'	=> base_url().'supplies/supplies_detail/'.$redirect_id,
                );
        }
	} 

	protected function assign_data_supplies( $input )
	{
		return array(
				'ITEMS'	=> $input['items'],
				'UNITCOST'		=> $input['unit_cost'],
				'QTYACQUIRED'	=> $input['qty_acquired'],
				'QTYONHAND'	=> $input['qty_acquired'],
				'DATEACQUIRED'	=> $input['dateacquired'],
				'EST_USEFUL_LIFE'		=> $input['estimated_useful_life'],
				'EUL_UNIT'	=> $input['eul_unit'],
			);
	}

	public function get_supplies( $supphist_id=null )
	{
		return $this->resultArray('supplies', array('ID' => $supphist_id));
	}

	public function get_onqueue( $itemid=null )
	{
		return $this->resultArray('supplies', array('ITEMS' => $itemid, 'ONQUEUE' => 1));
	}

	public function item_list()
    {
        $this->db->select('ID, CODE, DESCRIPTION');
        $this->db->from('items');
		$this->db->where('ACTIVE', 1);
		$this->db->where('category', 'supply');
        $this->db->order_by('DESCRIPTION');

        return $this->resultArray();
	}

}
