<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class RIS_model extends Home_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function fetch_datable_item_list()
	{
		$tableset = array(
                'object'    => 'items',
                'index'     => 'ID',
                'join'      => null,
                'where'     => null,
                'group'     => null,
                'columns'   => array(
                        'ID',
                        'CODE',
                        'CATEGORY',
                        'DESCRIPTION',
                        'UNIT',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
	}

	public function get_item($item_id)
	{
		$this->db->select('DISTINCT(items.description), items.code, items.unit, items.id');
		$this->db->from('supplies');
		$this->db->join('items', 'items.id = supplies.items', 'left');
		$this->db->where('supplies.id', $item_id);
		$this->db->group_by('description');
		return $this->resultArray();
	}

	public function fetch_datable_ris_list()
	{
		$tableset = array(
                'object'    => 'ris',
                'index'     => 'ris.ID',
                'join'      => 'LEFT JOIN offices ON offices.id = ris.offices',
                'where'     => null,
                'group'     => null,
                'columns'   => array(
                        'ris.ID',
                        'offices.DESCRIPTION',
                        'RIS_NO',
                        'PURPOSE',
                        'REQUESTED_BY',
                        'REQUESTED_DATE',
                    ),
            );
        return $this->DataTable( $this->activegroup, $tableset);
	}

    public function get_ris_item_list($risid)
    {
        $this->db->select('ris_items.id as ris_items_id, ris_items.*, items.*');
        $this->db->from('ris_items');
        $this->db->join('items', 'items.id = ris_items.`req_description`', 'left');
        $this->db->where('ris_no', $risid);
        return $this->resultArray();
    }

    public function get_ris_item($risid)
    {
        $this->db->select('*');
        $this->db->from('ris_items');
        $this->db->where('id', $risid);
        
        return $this->resultArray();
    }

    public function get_ris($column = 'ris.id' , $value=null, $child=false)
    {
        $this->db->select('*');
        $this->db->from('ris');
        $this->db->join('offices', 'ON ris.offices = offices.id', 'left');
        $this->db->where($column, $value);

        $result = $this->resultArray();

        if( $child === false )
            return $result;
        else {
            $data = array(
                    array(
                            'index' => 'ITEMS',
                            'value' => $this->get_ris_item_child('RIS', $value, 1),
                        ),
                );

            return $this->resultArrayAppend( $result, $data );
        }
    }

    public function get_ris_item_child($column=string, $value=string, $child=false)
    {
        $this->db->select('ris_items.ID, ris_items.RIS, REQ_STOCK_NO, REQ_UNIT, items.`DESCRIPTION`, REQ_QTY, AVAILABILITY, ISSUED_QTY, ISSUED_REMARKS');
        $this->db->from('ris_items');
        $this->db->join('supplies', 'supplies.ITEMS = ris_items.`REQ_DESCRIPTION`', 'left');
        $this->db->join('items', 'ris_items.REQ_DESCRIPTION = items.ID', 'left');
        $this->db->where($column, $value);
        $this->db->group_by('ris_items.`REQ_DESCRIPTION`');

        $result = $this->resultArray();

        return $result;
    }

    public function get_ris_rec($risid)
    {
        $this->db->select('*');
        $this->db->from('ris');
        $this->db->where('ris_no', $risid);
        return $this->resultArray();
    }

    public function get_supplies($itemid)
    {
        $this->db->select('*');
        $this->db->from('supplies');
        $this->db->where('items', $itemid);
        $this->db->where('active', 1);
        $this->db->order_by('createddate');
        return $this->resultArray();
	}
	
	public function manage_ris( $input=null )
    {
        $this->db->trans_start();
		if($input['action'] != 'delete'){
			$data = $this->assign_data_ris( $input );
		}
        
        switch( $input['action'] )
        {
        	case 'update':
        		$data['MODIFIEDBY']	= $this->session->userdata('EMPLOYEENO');
        		$data['MODIFIEDDATE'] = date('Y-m-d h:i:s');

        		$this->db->where('ID', $input['hidden_prop_id']);
        		$this->db->update('properties', $data);

        		$redirect_id = $input['hidden_prop_id'];
				break;
				
			case 'delete':
				$data['MODIFIEDBY']	= $this->session->userdata('EMPLOYEENO');
				$data['MODIFIEDDATE'] = date('Y-m-d h:i:s');
				$data['ACTIVE'] = 0;

				$this->db->where('ID', $input['prop_id']);
				$this->db->update('properties', $data);

				$redirect_id = $input['prop_id'];
				break;

        	case 'insert':
        	default:
        		$data['CREATEDBY']	= $this->session->userdata('EMPLOYEENO');
        		$data['CREATEDDATE'] = date('Y-m-d h:i:s');

        		$this->db->insert('ris', $data);
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
                    'message'   => 'RIS has been successfully saved.',
                    'redirect'	=> base_url().'properties_and_equipment/properties_detail/'.$redirect_id,
                );
        }
	} 

	protected function assign_data_ris( $input )
	{
		return array(
				'ris_no'	=> $input['ris_no'],
				'offices'		=> $input['dept'],
				'purpose'	=> $input['purpose'],
			);
	}

	public function getrisno()
    {
        $this->db->select('ID, RIS_NO');
        $this->db->from('ris');
		$this->db->where('ACTIVE', 1);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);

        return $this->resultArray();
	}
}
