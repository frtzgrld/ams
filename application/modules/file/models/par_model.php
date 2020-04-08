<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class PAR_model extends Home_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function fetch_datable_par_list($status)
	{
        $where =  $status ? 'WHERE status = '.$status : null;
		$tableset = array(
                'object'    => 'par',
                'index'     => 'ID',
                'join'      => null,
                'where'     => $where,
                'group'     => null,
                'columns'   => array(
                        'id',
                        'fund_cluster',
                        'par_no',
                        'created_date',
                        'issued_by',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
	}

	public function get_par_rec($parid)
	{
		$this->db->select('par.id, fund_cluster, par_no, received_by, received_by_position, received_by_date, issued_by, issued_by_position, issued_by_date, status');
		$this->db->from('par');
        // $this->db->join('par_details', 'par_details.par = par.id', 'left');
		$this->db->where('par.id', $parid);
		return $this->resultArray();
	}

	public function get_par_item_list($parid)
	{
		$this->db->select('properties.id, propertyno, description, unitcost, dateacquired');
		$this->db->from('properties');
        $this->db->join('par_details', 'properties.id = par_details.property', 'left');
		$this->db->where('par_details.par', $parid);
        $this->db->where('par_details.active', 1);
		// $this->db->where('form_type', 2);
		// $this->db->where('unitcost > 15000');
		return $this->resultArray();
		
	}

	public function fetch_datable_par_items_list($stat)
	{
        $where = "";
        if($stat == 0)
        {
            $where = 'WHERE (status=0 or status IS NULL)';
        }
        else
        {
            $where = 'WHERE (status != 0)';
        }
		 $tableset = array(
                'object'    => 'properties',
                'index'     => 'ID',
                'join'      => null,
                // 'where'     => 'WHERE (are=0 or are IS NULL) and form_type = 0 and unitcost > 15000',
                'where'     => $where,
                'group'     => null,
                'columns'   => array(
                        'ID',
                        'PROPERTYNO',
                        'DESCRIPTION',
                        'UNITCOST',
                        'EST_USEFUL_LIFE',
                    ),
            );
        return $this->DataTable( $this->activegroup, $tableset);
	}

	public function update_par_header($input)
	{
		$data = array(
			'fund_cluster'	=> $input['fund_cluster'],
			'par_no'		=> $input['par_no'],
			'received_by'	=> $input['received_by'],
			'received_by_position'	=> $input['received_by_position'],
			'received_by_date'	=> $input['received_by_date'],
			'issued_by'		=> $input['issued_by'],
			'issued_by_position'	=> $input['issued_by_position'],
			'issued_by_date'	=> $input['issued_by_date'],
			);

		// print_r($input);
  //       exit();

		$this->db->where('id', $input['par_id']);
		$this->db->update('par', $data);
	}

	public function get_par($column = 'par.id' , $value=null, $child=false)
    {
        $this->db->select('par.ID, par.PAR_NO, par.FUND_CLUSTER, par.RECEIVED_BY, par.RECEIVED_BY_POSITION, par.RECEIVED_BY_DATE, par.ISSUED_BY, par.ISSUED_BY_POSITION, par.ISSUED_BY_DATE, par.CREATED_DATE');
        $this->db->from('par');
        // $this->db->join('offices', 'ON are.offices = offices.id', 'left');
        $this->db->where($column, $value);

        $result = $this->resultArray();
        // print_r($result);
        // echo $value;
        // exit();
        if( $child === false )
            return $result;
        else {
            $data = array(
                    array(
                            'index' => 'PROPERTIES',
                            'value' => $this->get_par_item('ARE', $value, 1),
                        ),
                );

            return $this->resultArrayAppend( $result, $data );
        }

    }

    public function get_par_item($column=string, $value=string, $child=false)
    {
        $this->db->select('ID, ARE, DESCRIPTION, CLASSCODE, DATEACQUIRED, PROPERTYNO, UNITCOST');
        $this->db->from('properties');
        $this->db->where($column, $value);
        $this->db->where('form_type', 2);
        $this->db->where('unitcost > 15000');

        $result = $this->resultArray();

        return $result;
    }

    public function get_property_list($prop_id)
    {
        $this->db->select('*');
        $this->db->from('properties');
        $this->db->where('id', $prop_id);
        $this->db->where('active', 1);
        return $this->resultArray();
    }

    public function get_par_det($prop_id)
    {
        $this->db->select('*');
        $this->db->from('par_details');
        $this->db->where('property', $prop_id);
        $this->db->where('active', 1);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        
        return $this->resultArray();    
       
    }
}