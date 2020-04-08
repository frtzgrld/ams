<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class Activity_Model extends Home_Model
{
	function __construct()
    {
        parent::__construct();
    }


    public function calendar_of_activities( $year=NULL, $month=NULL, $date=NULL )
    {
        $this->db->select('pp.assigneddate');
        $this->db->from('lots l');
        $this->db->join('procurement_procedures pp', 'pp.lots = l.id', 'inner');
        $this->db->join('procedures pd', 'pd.id = pp.procedures', 'inner');
        $this->db->where('l.active', 1);

        if($year)   $this->db->where('year(pp.assigneddate)', $year);
        if($month)  $this->db->where('month(pp.assigneddate)', $month);
        if($date)   $this->db->where('day(pp.assigneddate)', $date);

        $this->db->order_by('assigneddate');
        $this->db->distinct('pp.assigneddate');

        $activities = $this->resultArray();
        $date_set = array();

        if( $activities )
        {
            foreach ($activities as $row) 
            {
                $date_set[] = array(
                        'date'  => $row['assigneddate'],
                        'task'  => $this->get_activities_by_date( $row['assigneddate'] ),
                    );
            }

            return $date_set;
        }

        return NULL;
    }


    public function get_activities_by_date( $date=null )
    {
        $result = $this->db->get_where('VW_TASKS_BY_DATE', array('ASSIGNEDDATE' => $date));

        return $this->resultArray($result);
    }


    public function __calendar_of_activities( $year=NULL, $month=NULL, $date=NULL )
    {
        $this->db->select('pp.assigneddate');
        $this->db->from('lots l');
        $this->db->join('procurement_procedures pp', 'pp.lots = l.id', 'inner');
        $this->db->join('procedures pd', 'pd.id = pp.procedures', 'inner');
        $this->db->where('l.active', 1);

        if($year)   $this->db->where('year(pp.assigneddate)', $year);
        if($month)  $this->db->where('month(pp.assigneddate)', $month);
        if($date)   $this->db->where('day(pp.assigneddate)', $date);

        $this->db->order_by('assigneddate');
        $this->db->distinct('pp.assigneddate');

        $activity = $this->resultArray();

        $date_set = array();

        if( $activity )
        {
            foreach ($activity as $row) {
                $date = (int)date_format( date_create($row['assigneddate']), 'd' );
                // $date_set[$date] = base_url().'tools/calendar/activities/'.date_format( date_create($row['assigneddate']), 'Y/m/d' );
                $date_set[$date] = 'javascript:getActivity(\''.$row['assigneddate'].'\');';
            }

            return $date_set;
        }

        return NULL;
    }
}