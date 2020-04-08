<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'modules/file/models/file_model.php' );

Class Quotation_Model extends File_Model
{
	function __construct()
    {
        parent::__construct();

        $this->load->model('purchase_requests/purchase_requests_model');
    }

    
    public function fetch_datable_quotation()
    {
        $tableset = array(
                'object'    => 'VW_QUOTATIONS',
                'index'     => 'ID',
                'join'      => null,
                'where'     => null,
                'group'     => null,
                'columns'   => array(
                        'QUOTATION_NO',
                        'PR_NO',
                        'APP',
                        'CANVAS_NO',
                        'DATEPOSTED',
                        'AUTHORITY',
                        'ID'
                    ),
            );

        return $this->DataTable( $this->activegroup, $tableset);
    }



    public function get_quotation( $where_array=array(), $child=false )
    {
        $this->load->model('procurement/procurement_model');

        $quot = $this->db->get_where('QUOTATIONS', $where_array);

        $result = $this->resultArray($quot);

        $result[0]['PURCHASE_REQUESTS'] = $this->purchase_requests_model->get_purchase_request('PR.ID', $result[0]['PURCHASE_REQUESTS'], TRUE);
        $result[0]['AUTHORITY'] = $this->procurement_model->fetch_procurement_modes(array('ID'=>$result[0]['AUTHORITY']));
        
        return $result;
    }


    public function save_quotation( $input=null )
    {
        $this->db->trans_start();
        
        $auth = $input['rq_authority'];
        $auth = explode('%2D', $auth);

        $data = array(
                'QUOTATION_NO'  => $input['rq_quot_no'],
                'PURCHASE_REQUESTS' => $input['rq_pr_no'],
                'CANVAS_NO'     => $input['rq_canvas_no'],
                'DATEPOSTED'    => date_format( date_create($input['rq_date']), 'Y-m-d'),
                'POSTED_BY'     => $this->session->userdata('EMPLOYEENO'),
                'AUTHORITY'     => $auth[0],
                'AUTHORITY_NO'  => $input['rq_auth_no'],
                'AUTHORITY_DATE'=> date_format( date_create($input['rq_auth_date']), 'Y-m-d'),
                'DEADLINE_OF_SUBMISSION' => date_format( date_create($input['rq_deadline']), 'Y-m-d'),
            );

        switch( $input['hidden_action'] )
        {
            case 'update':
                $data['MODIFIEDBY'] = $this->session->userdata('EMPLOYEENO');
                $data['MODIFIEDDATE'] = date('Y-m-d h:i:s');
                $this->db->where('ID', $input['hidden_quotation_id']);
                $this->db->update('QUOTATIONS', $data);
                break;

            case 'insert':
            default:
                $data['CREATEDBY'] = $this->session->userdata('EMPLOYEENO');
                $this->db->insert('QUOTATIONS', $data);
                $input['hidden_return_address'] = 'file/quotations/quotation_detail/'.$this->db->insert_id();
                break;
        }

        $redirect = $input['hidden_return_address'] != null ? base_url().$input['hidden_return_address'] : null;

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->commonErrorResponse();
        } else {
            $this->db->trans_commit();
            return array(
                    'result'    => 'success',
                    'header'    => 'SUCCESS',
                    'message'   => 'Request has been successfully saved.',
                    'redirect'  => $redirect,
                );
        }
    }


    public function save_date_extension( $input=null )
    {
        $this->db->trans_start();
        
        $data = array(
                'PROCEDURE' => nullable($input['hidden_procedure_id']),
                'LOTNO'     => $input['hidden_lot_no_2'],
                'DATE'      => date_format( date_create($input['date']), 'Y-m-d'),
                // 'SERIES'    => $input[''],
                'NOTES'     => $input['notes'],
            );

        switch( $input['hidden_action_2'] )
        {
            case 'update':
                $this->db->where('ID', $input['hidden_quotation_id']);
                $this->db->update('EXTENDED_DATES', $data);
                break;

            case 'insert':
            default:
                $this->db->insert('EXTENDED_DATES', $data);
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
                    'message'   => 'Request has been successfully saved.',
                );
        }
    }
}