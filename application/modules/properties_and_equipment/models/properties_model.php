<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class Properties_Model extends Home_Model
{
	function __construct()
    {
        parent::__construct();
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
                        'STATUS',
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
	
	public function get_acquisition_detail( $category=null, $identity=null, $child=false )
    {
		
		$result = "";
        switch( $category )
        {
            case 'supply':
                $items = $this->db->get_where('VW_INVENTORY_SUPPLIES', array('ITEMID' => $identity));
                break;

			case 'property':
				$this->db->select("*");
				$this->db->from("properties");
				// $this->db->join("users", "par.RECEIVED_BY = users.EMPLOYEENO", "left");
				// $this->db->join("par_details", "par_details.PAR = par.id", "left");
				// $this->db->join("properties", "properties.id = par_details.PROPERTY", "left");
				$this->db->where("properties.id",$identity);
				$this->db->where("properties.active", 1);
				$result = $this->resultArray();
				// var_dump($result);
				// exit();
                break;
        }
    	
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

	    return $result;
	}

	public function save_prop($input=null)
	{
		$this->db->insert('properties', 
		array(
			'property_no' => $this->input->post('property_no'), 
			'items'	=> $this->input->post('property'),
			'description'	=> $this->input->post('description'),
			'dateacquired'	=>	$this->input->post('date_acquired'), 
			'unitcost'	=> $this->input->post('unit_cost'),
			'est_useful_life'	=> $this->input->post('estimated_useful_life'),
			'eul_unit'	=> $this->input->post('eul_unit'),
			'active'	=> 1,
			'status'	=> 0,
			'createdby' => $this->session->userdata('USERID'),
			'createddate' => date('Y-m-d h:i:s')
			)
		);
		return "success";
	}
	
	public function item_list()
    {
        $this->db->select('ID, CODE, DESCRIPTION');
        $this->db->from('items');
		$this->db->where('ACTIVE', 1);
		$this->db->where('category', 'property');
        $this->db->order_by('DESCRIPTION');

        return $this->resultArray();
	}
	
	public function manage_property( $input=null )
    {
        $this->db->trans_start();
		if($input['action'] != 'delete'){
			$data = $this->assign_data_property( $input );
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

        		$this->db->insert('properties', $data);
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
                    'message'   => 'Property has been successfully saved.',
                    'redirect'	=> base_url().'properties_and_equipment/properties_detail/'.$redirect_id,
                );
        }
	} 

	protected function assign_data_property( $input )
	{
		return array(
				'propertyno'	=> $input['property_no'],
				'items'		=> $input['property'],
				'description'	=> $input['description'],
				'unitcost'	=> $input['unit_cost'],
				'est_useful_life'		=> $input['estimated_useful_life'],
				'eul_unit'	=> $input['eul_unit'],
				'dateacquired'	=> $input['date_acquired'],
			);
	}

	public function get_prop( $prop_id=null )
	{
		return $this->resultArray('properties', array('ID' => $prop_id));
	}
}
