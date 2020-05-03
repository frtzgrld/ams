<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/home_model.php' );

Class Inventory_Model extends Home_Model
{
	function __construct()
    {
        parent::__construct();
    }


    public function index()
    {

    }


    public function get_acquisition_detail( $category=null, $identity=null, $child=false )
    {
        switch( $category )
        {
            case 'supply':
                $items = $this->db->get_where('VW_INVENTORY_SUPPLIES', array('ITEMID' => $identity));
                break;

            case 'property':
                $items = $this->db->get_where('VW_INVENTORY_PROPERTIES', array('ITEMID' => $identity));
                break;
        }
    	
    	$result = $this->resultArray($items);
        // print_r($result);
        // exit();

    	if( $child )
    	{
	    	$data = array(
	                array(
	                        'index' => 'RECEIVED',
	                        'value' => $this->get_acquisition_items( $identity ),
	                    ),
	                );

	        return $this->resultArrayAppend( $result, $data );
	    }

	    return $result;
    }


    public function get_acquisition_items( $identity=null )
    {
    	$this->db->select("S.ID AS SUPPLYID, S.UNIT, S.UNITCOST, S.QTYACQUIRED, S.DATEACQUIRED, S.QTYONHAND, S.EST_USEFUL_LIFE, S.EUL_UNIT, SALVAGE_VALUE, SPR.COMPANYNAME AS SUPPLIER, S.ONQUEUE", TRUE); // --I.ID AS ITEMID, I.DESCRIPTION AS ITEMS, 
		$this->db->from('SUPPLIES S');
		$this->db->join('ITEMS I', 'I.ID = S.ITEMS', 'INNER');
		$this->db->join('SUPPLIER SPR', 'SPR.ID = S.SUPPLIER', 'LEFT');
		$this->db->where('I.ID', $identity);

		return $this->resultArray();
    }


    public function get_disposal_types()
    {
        $this->db->select('ID, DESCRIPTION')->from('DISPOSAL_TYPE')->order_by('DESCRIPTION');

        return $this->resultArray();
    }


    public function manage_disposal($input=null)
    {
        $this->db->trans_start();
        
        $data = array(
                'ITEMS'         => $input['disposing_item'],
                'QTY'           => nullable($input['disposing_qty']==0?1:$input['disposing_qty']),
                'PROPERTYNO'    => nullable($input['propertyno']),
                'DISPOSAL_TYPE' => $input['disp_type'],
                'REMARK'        => nullable($input['remark']),
            );

        // print_r($data); die();
        // switch( $input['hidden_action'] )
        // {
        //     case 'update':
        //         break;

        //     case 'insert':
        //     default:
                $data['DISPOSEDBY'] = $this->session->userdata('EMPLOYEENO');
                $data['DISPOSEDDATE'] = date('Y-m-d h:i:s');
                $this->db->insert('DISPOSAL', $data);
        //         break;
        // }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->commonErrorResponse();
        } else {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success',
                    'header'    => 'SUCCESS',
                    'message'   => 'Disposal record has been successfully saved.',
                );
        }
    }


    public function manage_received_stocks( $input=null )
    {
        $this->db->trans_start();
        
        // print_r($input); die();

        for($i=0; $i<count($input['hidden_order_item_id']); $i++)
        {
            if( $input['item_category_'.$input['hidden_order_item_id'][$i]]=='supply' )
            {
                $dataset = array(
                        'ITEMS'         => $input['item_'.$input['hidden_order_item_id'][$i]],
                        'UNIT'          => $input['hidden_item_unit_'.$input['hidden_order_item_id'][$i]],
                        'UNITCOST'      => $input['unitcost_'.$input['hidden_order_item_id'][$i]],
                        'SUPPLIER'      => $input['hidden_supplier_id_'.$input['hidden_order_item_id'][$i]],
                        // 'CATEGORY'      => $input['item_category_'.$input['hidden_order_item_id'][$i]],
                        'QTYACQUIRED'   => $input['quantity_'.$input['hidden_order_item_id'][$i]],
                        'DATEACQUIRED'  => date_format( date_create($input['dateacquired_'.$input['hidden_order_item_id'][$i]]), 'Y-m-d'),
                    );

                $dataset['CREATEDBY'] = $this->session->userdata('EMPLOYEENO');
                $this->db->insert('SUPPLIES', $dataset);
            }
            else
            {
                for ($item=0; $item < count($input['propertyno_'.$input['hidden_order_item_id'][$i]]); $item++) 
                {
                    $dataset = array(
                            'ARE'           => NULL,
                            'PROPERTYNO'    => $input['propertyno_'.$input['hidden_order_item_id'][$i]][$item],
                            'SERIALNO'      => $input['serialno_'.$input['hidden_order_item_id'][$i]][$item],
                            'ITEMS'         => $input['item_'.$input['hidden_order_item_id'][$i]],
                            'CATEGORY'      => $input['item_category_'.$input['hidden_order_item_id'][$i]],
                            'DESCRIPTION'   => $this->get_record('ITEMS', 'DESCRIPTION', array('ID' => $input['item_'.$input['hidden_order_item_id'][$i]])),
                            'MODEL'         => $input['brand_'.$input['hidden_order_item_id'][$i]][$item],
                            'DATEACQUIRED'  => date_format( date_create($input['dateacquired_'.$input['hidden_order_item_id'][$i]]), 'Y-m-d'),
                            'UNITCOST'      => $input['unitcost_'.$input['hidden_order_item_id'][$i]],
                            'QTYONHAND'     => 1,
                            'PROVIDER'      => $input['hidden_supplier_id_'.$input['hidden_order_item_id'][$i]],
                            'EST_USEFUL_LIFE'=> $input['useful_life_'.$input['hidden_order_item_id'][$i]],
                            'EUL_UNIT'      => 'year',
                            'ONQUEUE'       => 1,
                        );

                    $dataset['CREATEDBY'] = $this->session->userdata('EMPLOYEENO');
                    $this->db->insert('PROPERTIES', $dataset);
                }
            }
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
                    'message'   => 'Disposal record has been successfully saved.',
                    'redirect'  => base_url().'delivery',
                );
        }
    }
}