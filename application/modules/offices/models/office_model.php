<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/Home_Model.php' );

Class Office_Model extends Home_Model
{
	function __construct()
    {
        parent::__construct();
    }

    public function get_office_detail( $column_name=null, $column_value=null, $child=false )
    {
        $this->db->select('o.ID AS OFFICEID, o.CODE, o.DESCRIPTION, o.ACRONYM, o.PARENT, o.RANK, p.DESCRIPTION AS PARENT_DESC, o.HAS_PPMP, o.CREATEDDATE, o.CREATEDBY, o.MODIFIEDBY, o.MODIFIEDDATE');
        $this->db->from('offices o');
        $this->db->join('offices p', 'p.ID = o.PARENT', 'LEFT');

        if( $column_name && $column_value )
           $this->db->where($column_name, $column_value);

        $this->db->order_by('o.DESCRIPTION');

        $result = $this->resultArray();

        if( $child === false )
            return $result;
        else {
            $data = array(
                    array(
                            'index' => 'CHILDREN',
                            'value' => $this->get_office_detail('o.PARENT', $result[0]['OFFICEID'], false),
                        ),
                );

            return $this->resultArrayAppend( $result, $data );
        }
    }

    public function office_list_per_user( $in_array=true )
    {
        $this->db->select('ID, DESCRIPTION')->from('offices');

        if( $in_array )
            $this->db->where('ID in '.$this->offices_in_array());

        return $this->resultArray();
    }

    public function office_category()
    {
        $this->db->select('ID, CODE, CATEGORY, RANK');
        $this->db->from('OFFICE_CATEGORY');
        $this->db->order_by('RANK');

        return $this->resultArray();
    }

    public function office_list( $not_in=false, $in_aip=false, $where=null )
    {
        $this->db->select('ID, CODE, DESCRIPTION, ACRONYM, CATEGORY, AIP_ORDER');
        $this->db->from('offices');
        $this->db->where('ACTIVE', 1);

        if( $where )
            $this->db->where($where);

        if( $not_in===true )
            $this->db->where('ID NOT IN '.user_offices(array('ACTIVE'=>1),false, 'ID'));

        if( $in_aip )
            $this->db->order_by('AIP_ORDER');

        $this->db->order_by('DESCRIPTION');

        return $this->resultArray();
    }

    // public function office_in_hierarchy()
    // {
    //     $this->db->select("CASE WHEN GET_OFFICE_ANCESTRY(ID) = '' THEN CODE ELSE CONCAT(GET_OFFICE_ANCESTRY(ID),'-',CODE) END AS RESPCENTER,
    //         DESCRIPTION, ID, CODE");
    //     $this->db->from('OFFICES');
    //     $this->db->order_by('RESPCENTER','ASC');

    //     return $this->resultArray();
    // }

    /*  Do this as our standard:
        For model methods where purpose is to display data for datatable, method name must be: 
        --  fetch_datatable_[unique term]
        --  all lower case
        */
    public function fetch_datable_offices()
    {
        $tableset = array(
                'object'    => 'offices',
                'index'     => 'id',
                'join'      => null,
                'where'     => 'where active = 1',
                'group'     => null,
                'columns'   => array(
                        'code',
                        'description',
                        'acronym',
                        'rank',
                        'has_ppmp',
                        'id',
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
    }

    //  This method is no longer needed
    protected function generate_office_code()
    {
        $this->db->select("MAX(SUBSTRING(CODE,4))+1 AS CODE", FALSE)->from('offices');

        $count = $this->resultRow('CODE');

        return $count ? 'OFF'.$count : 'OFF1000';
    }
    

    protected function data_office( $input=null )
    {
        return array(
                'DESCRIPTION'   => $input['office_desc'],
                'HAS_PPMP'      => $input['office_ppmp'],
                'CODE'          => $input['office_code'],
                'RANK'          => $input['office_rank'],
                'ACRONYM'       => $input['office_acronym'],
            );
    }

    
    public function insert_office( $input=null )
    {
        $this->db->trans_start();

        $data = $this->data_office( $input );
        // $data['CODE'] = $this->generate_office_code();
        $data['CREATEDBY'] = $this->session->userdata('FULLNAME');

        $this->db->insert('offices', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->common_failure_response();
        } else {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success',
                    'header'    => 'SUCCESS',
                    'message'   => 'New office has been successfully saved.',
                );
        }
    } 

    
    public function update_office( $input=null )
    {
        $this->db->trans_start();

        $data = $this->data_office( $input );
      
        if(!empty($data))
        {
            $data['MODIFIEDDATE'] = date('Y-m-d h:i:s');
            $data['MODIFIEDBY'] = $this->session->userdata('EMPLOYEENO');
            $this->db->where('ID', $input['hidden_office_id']);
            $this->db->update('offices', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return $this->common_failure_response();
            } else {
                $this->db->trans_commit();
                return array(
                        'result'    => 'success',
                        'header'    => 'SUCCESS',
                        'message'   => 'Office detail has been successfully updated.',
                    );
            }
        }
        else {
            # code...
            return $this->common_failure_response();
        }
    }



    public function office_hierarchy($column_name=null, $column_value=null)
    {
        $this->db->select('ID, DESCRIPTION');
        $this->db->from('offices');
        $this->db->where($column_name, $column_value);

        return $this->resultArray();
    }


    public function responsibility_center()
    {
        $offices = $this->get_office_detail('PARENT', NULL);

        // for ($i=0; $i < count($offices); $i++) {
        //     $offices[$i]['CHILD'] = $this->get_office_detail('PARENT', $offices[$i]['ID']);
        // }

        return $offices;
        
        // $map = array();

        // foreach ($offices as $node) {
        //   // init self
        //   if (!array_key_exists($node['ID'], $map)) {
        //     $map[$node['ID']] = array('OFFICE' => $node['DESCRIPTION']);
        //   }
        //   else {
        //     $map[$node['ID']]['OFFICE'] = $node['DESCRIPTION'];
        //   }

        //   // init parent
        //   if (!array_key_exists($node['PARENT'], $map)) {
        //     $map[$node['PARENT']] = array();
        //   }

        //   // add to parent
        //   $map[$node['PARENT']][$node['ID']] = & $map[$node['ID']];
        // }

        // return $map;
    }


    public function verify_unique_office_code($office_code=null, $office_id=null)
    {
        $this->db->select('CODE, ID', TRUE);
        $this->db->from('offices');
        $this->db->where('CODE', $office_code);

        $result = $this->resultArray();

        if( $result )
        {
            if( (int)$office_id > 0 && (int)$result[0]['ID']===(int)$office_id )
                return 'true';
            else
                return 'Office code already in use';
        }

        return 'true';
    }


    public function verify_unique_office_acronym($office_acronym=null, $office_id=null)
    {
        $this->db->select('ACRONYM, ID', TRUE);
        $this->db->from('offices');
        $this->db->where('ACRONYM', $office_acronym);

        $result = $this->resultArray();

        if( $result )
        {
            if( (int)$office_id > 0 && (int)$result[0]['ID']===(int)$office_id )
                return 'true';
            else
                return 'Abbreviation/acronym already in use';
        }

        return 'true';
    }

    public function get_office_heads( $id=null )
    {
        $this->db->select('o.ID AS OFFICEID, DESCRIPTION AS OFFICE, FULLNAME, DESIGNATION', FALSE);
        $this->db->from('offices o');
        $this->db->join('office_heads h', 'h.OFFICE = o.ID AND h.FLAG = 1', 'LEFT');

        return $this->resultArray();
    }


    public function save_office_heads( $input=null )
    {
        $this->db->trans_start();

        for ($i=0; $i < count($input['office']); $i++) 
        {
            $data = array(
                    'OFFICE'        => $input['office'][$i],
                    'FULLNAME'      => nullable($input['fullname'][$i]),
                    'DESIGNATION'   => nullable($input['designation'][$i]),
                    'FLAG'          => 1,
                );

            if( $this->if_office_exist($input['office'][$i]) )
            {
                $this->db->where('OFFICE', $input['office'][$i]);
                $this->db->update('OFFICE_HEADS', $data);
            }
            else
            {
                $this->db->insert('OFFICE_HEADS', $data);
            }
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
                    'message'   => 'Record successfully saved.',
                );
        }
    }


    private function if_office_exist( $office_id=null )
    {
        $this->db->select('OFFICE')->from('OFFICE_HEADS')->where('OFFICE', $office_id);

        return $this->resultRow('OFFICE');
    }


    public function get_document_signatory( $document=null, $designation=null, $display='FULLNAME' )
    {
        $this->db->select('FULLNAME, DESIGNATION, OH.OFFICE', FALSE);
        $this->db->from('DOCUMENT_SIGNATORIES DS');
        $this->db->join('OFFICE_HEADS OH', 'OH.ID = DS.OFFICE_HEADS AND FLAG = 1', 'LEFT');
        $this->db->where('DOCUMENT', $document);
        $this->db->where('SIGNATORY', $designation);

        return $this->resultRow($display);
    }


    public function save_document_sign( $input=null )
    {
        $this->db->trans_start();

        switch ($input['document']) 
        {
            case 'Disbursement Voucher':
                $this->db->where('DOCUMENT', 'Disbursement Voucher');
                $this->db->where('SIGNATORY', 'Accounting Unit');
                $this->db->update('DOCUMENT_SIGNATORIES', array('OFFICE_HEADS' => $input['accounting']));

                $this->db->where('DOCUMENT', 'Disbursement Voucher');
                $this->db->where('SIGNATORY', 'Treasurer');
                $this->db->update('DOCUMENT_SIGNATORIES', array('OFFICE_HEADS' => $input['treasurer']));

                $this->db->where('DOCUMENT', 'Disbursement Voucher');
                $this->db->where('SIGNATORY', 'Agency Head');
                $this->db->update('DOCUMENT_SIGNATORIES', array('OFFICE_HEADS' => $input['agency_head']));
                break;
            
            default:
                # code...
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
                    'message'   => 'Detail successfully saved.',
                );
        }
    }

    public function crud_office($post)
    {
        if ($post['action'] == 'delete'){
            $data = array(
                'active' => 0,
                'MODIFIEDBY' => $this->session->userdata('EMPLOYEENO'),
                'MODIFIEDDATE' => date('Y-m-d h:i:s')
            );
            $this->db->where('id', $post['id']);
            $this->db->update('offices', $data);
            $new_id = $post['id'];
        }

        return "success";
       
    }
}
