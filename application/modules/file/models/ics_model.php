<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class ICS_model extends Home_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function fetch_datable_ics_list()
	{
		$tableset = array(
                'object'    => 'ics',
                'index'     => 'ID',
                'join'      => null,
                'where'     => null,
                'group'     => null,
                'columns'   => array(
                        'id',
                        'fund_cluster',
                        'ics_no',
                        'created_date',
                        'issued_by',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
	}

	public function get_ics_rec($icsid)
	{
		$this->db->select('id, fund_cluster, ics_no, received_from, received_from_position, received_from_date, issued_by, issued_by_position, issued_by_date');
		$this->db->from('ics');
		$this->db->where('id', $icsid);
		return $this->resultArray();
	}

	public function get_ics_item_list($icsid)
	{
		$this->db->select('id, are, propertyno, form_type, description, unitcost, dateacquired');
		$this->db->from('properties');
		$this->db->where('are', $icsid);
		$this->db->where('form_type', 1);
		$this->db->where('unitcost < 15000');
		return $this->resultArray();
	}

	public function fetch_datable_ics_items_list()
	{
		$tableset = array(
                'object'    => 'properties',
                'index'     => 'ID',
                'join'      => null,
                'where'     => 'WHERE (are=0 or are IS NULL) and form_type = 0 and unitcost < 15000',
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

	public function update_ics_header($input)
	{
		$data = array(
			'fund_cluster'	=> $input['fund_cluster'],
			'ics_no'		=> $input['ics_no'],
			'received_from'	=> $input['received_from'],
			'received_from_position'	=> $input['received_from_position'],
			'received_from_date'	=> $input['received_from_date'],
			'issued_by'		=> $input['issued_by'],
			'issued_by_position'	=> $input['issued_by_position'],
			'issued_by_date'	=> $input['issued_by_date'],
			);

		// print_r($input);
  //       exit();

		$this->db->where('id', $input['ics_id']);
		$this->db->update('ics', $data);
	}

	public function get_ics($column = 'ics.id' , $value=null, $child=false)
    {
        $this->db->select('ics.ID, ics.ICS_NO, ics.FUND_CLUSTER, ics.RECEIVED_FROM, ics.RECEIVED_FROM_POSITION, ics.RECEIVED_FROM_DATE, ics.ISSUED_BY, ics.ISSUED_BY_POSITION, ics.ISSUED_BY_DATE, ics.CREATED_DATE');
        $this->db->from('ics');
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
                            'value' => $this->get_ics_item('ARE', $value, 1),
                        ),
                );

            return $this->resultArrayAppend( $result, $data );
        }

    }

    public function get_ics_item($column=string, $value=string, $child=false)
    {
        $this->db->select('ID, ARE, DESCRIPTION, CLASSCODE, DATEACQUIRED, PROPERTYNO, UNITCOST, EST_USEFUL_LIFE');
        $this->db->from('properties');
        $this->db->where($column, $value);
        $this->db->where('form_type', 1);
        $this->db->where('unitcost < 15000');

        $result = $this->resultArray();

        return $result;
    }
}