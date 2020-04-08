<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php');

Class Items_model extends Home_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function __get_items_record($id)
	{
		$this->db->select('id, code, description, unit, parent, category');
		$this->db->from('items');
		$this->db->where('active', 1);
		$this->db->where('id', $id);

		return $this->resultArray();
	}


	public function get_item_detail( $column_name=null, $column_value=null, $child=false )
    {
        $this->db->select('i.ID AS ITEMID, i.CODE, i.DESCRIPTION, i.UNIT, i.PARENT, p.DESCRIPTION AS PARENT_DESC, i.CATEGORY, i.MINQTY, i.MAXQTY, i.CREATEDBY, i.CREATEDDATE, i.MODIFIEDBY, i.MODIFIEDDATE');
        $this->db->from('items i');
        $this->db->join('items p', 'p.ID = i.PARENT', 'LEFT');

        if( $column_name && $column_value )
    	   $this->db->where($column_name, $column_value);

    	$result = $this->resultArray();

    	if( $child === false )
    		return $result;
    	else {
	    	$data = array(
	    			array(
	    					'index'	=> 'CHILDREN',
	    					'value'	=> $this->get_item_detail('i.PARENT', $column_value, false),
	    				),
	    		);

	    	return $this->resultArrayAppend( $result, $data );
	    }
    }


	public function fetch_datable_items()
	{
		$tableset = array(
                'object'    => 'items',
                'index'     => 'id',
                'join'      => null,
                'where'     => 'where active = 1',
                'group'     => null,
                'columns'   => array(
                        'code',
                        'description',
                        'category',
                        'unit',
                        'id',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
	}

	public function get_parent_items()
	{
		$this->db->select('id, description');
		$this->db->from('items');
		$this->db->where('parent', 0);
		$this->db->where('active', 1);

		return $this->resultArray();
	}

	//	for list of items in select2
	public function get_options_items( $category=null, $leaf_only=false, $item_id=null )
	{
		$this->db->select('I.ID, I.CODE, I.DESCRIPTION, S.NO_OF_STOCKS, I.CATEGORY, I.UNIT');
		$this->db->from('items I');
		$this->db->join('stocks S', 'S.ITEMS = I.ID', 'LEFT');
		$this->db->where('I.ACTIVE', 1);
		
		if( $category )
			$this->db->where('I.CATEGORY', $category);

		if( $leaf_only )
			$this->db->where('I.ID NOT IN (SELECT PARENT FROM ITEMS)');

		if( $item_id )
			$this->db->where('I.ID', $item_id);
		else
			$this->db->order_by('I.DESCRIPTION');

		return $this->resultArray();
	}


	public function get_item( $item_id=null )
	{
		return $this->resultArray('items', array('ID' => $item_id));
	}


	protected function assign_data_item( $input )
	{
		return array(
				'CATEGORY'	=> $input['category'],
				'CODE'		=> $input['item_code'],
				'PARENT'	=> $input['parent'],
				'DESCRIPTION'	=> $input['description'],
				'UNIT'		=> $input['unit'],
				'MINQTY'	=> $input['minqty'],
				'MAXQTY'	=> $input['maxqty'],
			);
	}

	public function manage_items( $input=null )
    {
        $this->db->trans_start();

        $data = $this->assign_data_item( $input );

        switch( $input['action'] )
        {
        	case 'update':
        		$data['MODIFIEDBY']	= $this->session->userdata('EMPLOYEENO');
        		$data['MODIFIEDDATE'] = date('Y-m-d h:i:s');

        		$this->db->where('ID', $input['hidden_item_id']);
        		$this->db->update('items', $data);

        		$redirect_id = $input['hidden_item_id'];
        		break;

        	case 'insert':
        	default:
        		$data['CREATEDBY']	= $this->session->userdata('EMPLOYEENO');
        		$data['CREATEDDATE'] = date('Y-m-d h:i:s');

        		$this->db->insert('items', $data);
        		$redirect_id = $this->db->insert_id();

        		//	Include the newly added item to stock
        		$stockset = array(
        				'items'	=> $redirect_id,
        			);
        		$this->db->insert('stocks', $stockset);
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
                    'message'   => 'Item has been successfully saved.',
                    'redirect'	=> base_url().'items/items_detail/'.$redirect_id,
                );
        }
	} 
	
	public function crud_item($post)
	{
		if ($post['action'] == 'delete'){
            $data = array(
                'active' => 0,
                'MODIFIEDBY' => $this->session->userdata('EMPLOYEENO'),
                'MODIFIEDDATE' => date('Y-m-d h:i:s')
            );
            $this->db->where('id', $post['id']);
            $this->db->update('items', $data);
            $new_id = $post['id'];
        }

        return "success";
       
	}
}
