<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class ARE_model extends Home_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function fetch_datable_are_list()
	{
		$tableset = array(
                'object'    => 'are',
                'index'     => 'ID',
                'join'      => 'LEFT JOIN offices ON offices.id = are.offices',
                'where'     => null,
                'group'     => null,
                'columns'   => array(
                        'are.ID',
                        'offices.DESCRIPTION',
                        'ARE_NO',
                        'DATE',
                        'SERIALNO',
                        'RECEIVED_BY_DATE',
                    ),
            );
        return $this->DataTable( $this->activegroup, $tableset);
	}

    public function fetch_datable_are_items_list()
    {
        $tableset = array(
                'object'    => 'properties',
                'index'     => 'ID',
                'join'      => null,
                'where'     => 'WHERE ARE=0',
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

    public function get_are_item_list($areid)
    {
        $this->db->select('are.id, properties.id AS prop_id, properties.`PROPERTYNO`, properties.`DESCRIPTION`, properties.`DATEACQUIRED`, are.`SERIALNO`, are.`ARE_NO`, properties.`UNITCOST`');
        $this->db->from('are');
        $this->db->join('properties', 'are.id = properties.are', 'inner');
        // $this->db->join('items', 'properties.items = items.id', 'left');
        $this->db->where('are.id', $areid);
        return $this->resultArray();
    }

    public function get_item($prop_id)
    {
        $this->db->select('*');
        $this->db->from('properties');
        $this->db->where('id', $prop_id);
        return $this->resultArray();
    }

    public function get_are($column = 'are.id' , $value=null, $child=false)
    {
        $this->db->select('are.ID, are.ARE_NO, are.DATE, offices.DESCRIPTION, are.SERIALNO, are.LOCATION, are.REMARKS, 
are.RECEIVED_BY, are.RECEIVED_BY_POSITION, are.RECEIVED_BY_DATE, are.RECEIVED_FROM, are.RECEIVED_FROM_POSITION, are.RECEIVED_FROM_DATE,
offices.DESCRIPTION');
        $this->db->from('are');
        $this->db->join('offices', 'ON are.offices = offices.id', 'left');
        $this->db->where($column, $value);

        $result = $this->resultArray();

        if( $child === false )
            return $result;
        else {
            $data = array(
                    array(
                            'index' => 'PROPERTIES',
                            'value' => $this->get_are_item('ARE', $value, 1),
                        ),
                );

            return $this->resultArrayAppend( $result, $data );
        }

    }

    public function get_are_item($column=string, $value=string, $child=false)
    {
        $this->db->select('ID, ARE, DESCRIPTION, CLASSCODE, DATEACQUIRED, PROPERTYNO, UNITCOST');
        $this->db->from('properties');
        $this->db->where($column, $value);

        $result = $this->resultArray();

        return $result;
    }

    public function get_are_rec($areid)
    {
        $this->db->select('id, are_no, `date`, offices, serialno, location, remarks, received_by, received_by_position, received_by_date, received_from, received_from_position, received_from_date');
        $this->db->from('are');
        $this->db->where('id', $areid);
        return $this->resultArray();
    }

    public function update_are_header($input)
    {
        $data = array(
                'are_no' => $input['are_no'],
                'date' => date_format(date_create($input['date']), 'Y-m-d'),
                'offices' => $input['office'],
                'serialno' => $input['serialno'],
                'remarks' => $input['remarks'],
                'received_by' => $input['received_by'],
                'received_by_position' => $input['received_by_position'],
                'received_by_date' => date_format(date_create($input['received_by_date']), 'Y-m-d'),
                'received_from' => $input['received_from'],
                'received_from_position' => $input['received_from_position'],
                'received_from_date' => date_format(date_create($input['received_from_date']), 'Y-m-d') ,
            );
        // print_r($input);
        // exit();

        $this->db->where('id', $input['are_id']);
        $this->db->update('are', $data);
    }
}