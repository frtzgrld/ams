<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 |  Main_Model.php
 |  This will be the system's main model. All model inside the 'application/modules' folder 
 |  (as well as other model inside the 'application/models' folder), must extend this
 |  model in order to access the system's main server side processing features
 |  
 */

Class Main_Model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

    //  Initialize the name of the default database
    protected $activegroup = 'default';


    /**
     *  Get all the transactions granted to a user group
     *  @param $module (string) = the target module
     *  @param $operation (string) = the target operation (r,c,u,d,a,p,i)
     *  @return array
     */
    public function getAccessRights( $module='', $operation='' )
    {
        $this->db->select('AR.TCODE, AR.APPROVAL, TC.OPERATION, AR.ROLECODE', FALSE);
        $this->db->from('ACCESS_RIGHTS AR');
        $this->db->join('TRANSACTION_CODES TC', 'TC.TCODE = AR.TCODE', 'INNER');

        if( $this->session->userdata('ROLECODE') )
            $this->db->where('ROLECODE', $this->session->userdata('ROLECODE') );

        //  Filter access rights
        if( $module != '' )  $this->db->where('MODULE', $module );
        if( $operation != '') $this->db->where('OPERATION', $operation );

        return $this->resultArray();
    }


    public function getUserPermission( $module='', $operation='' )
    {
        $this->db->select('up.tcode, approval, tc.operation, g.rolecode, module');
        $this->db->from('users_permissions up');
        $this->db->join('users a', 'a.id = up.userid', 'inner');
        $this->db->join('user_group g', 'g.rolecode = a.user_group', 'inner');
        $this->db->join('users u', 'u.id = up.grantedby ', 'inner');
        $this->db->join('transaction_codes tc', 'tc.tcode = up.tcode ', 'inner');
        $this->db->where('a.account_no', $this->session->userdata('account_no'));
        $this->db->where('up.active', 1);
        
        if( $module != '' )  $this->db->where('module', $module );
        if( $operation != '') $this->db->where('operation', $operation );

        return $this->resultArray();
    }


    /**
     *  Simply check the accessibility of a user to a menu
     *  Method primarily used by the custom helper 'has_access'
     *  @param $tcode (string) = the transaction code
     *  @return Boolean
     */
    public function checkAccessibility( $tcode )
    {
        // return true;
        
        $this->db->select('ID');
        $this->db->from('access_rights');
        $this->db->where('ROLECODE', $this->session->userdata('ROLECODE') );

        if (strpos($tcode, ',') !== false)
            $this->db->where('TCODE IN ('.$tcode.')');
        else
            $this->db->where('TCODE', $tcode );
        
        $this->db->where('ACTIVE', 1 );

        return $this->resultArray();
    }


    /**
     *  Select from databases
     *  @param $database (string)   = The database name
     *  @return array
     */
    private function selectDatabase( $database=null )
    {
        if( $database )
            return $this->load->database($database, TRUE);
    }


    /**
     *  Method for server side processing of a jquery DataTable
     *
     *  @param $database (string)   = The database group name
     *  @param $data (array)        = an array set of detail and conditions
     *  @return json string
     *
     *  Example:
            $data = array(
                    'object'    => 'TableA A',
                    'index'     => 'TableA.key',
                    'join'      => 'inner join TableB B on B.key = A.key',
                    'where'     => 'where A.key = 1',
                    'group'     => null,
                    'columns'   => array(
                            'A.column1',
                            'A.column2',
                            'B.column5',
                            'B.key',
                        ),
                );

            return $this->Datatable( $this->activegroup, $data );

     */
    protected function DataTable( $database=null, $data=array(), $aggregate=null )
    {
		
        $this->db = $this->selectDatabase( $database );

        //  Total data set length
        switch ($this->db->dbdriver) 
        {
            case 'mysqli':  
                $sQuery = "SELECT (SELECT COUNT(".$aggregate." ".$data['index'].") FROM ".$data['object']." ".$data['join']." ".$data['where'].") AS row_count FROM " . $data['object']; 
				break;

            case 'sqlsrv':
                $sQuery = "SELECT COUNT('" . $data['index'] . "') AS row_count FROM " . $data['object'];
                break;

            default:
                break;
        }

        $rResultTotal = $this->db->query($sQuery);
        $aResultTotal = $rResultTotal->row();
        $iTotal = ($aResultTotal)?$aResultTotal->row_count:0;

        //  Paging
        $sLimit = "";
        $iDisplayStart = $this->input->get_post('start', true);
        $iDisplayLength = $this->input->get_post('length', true);

        if (isset($iDisplayStart) && $iDisplayLength != '-1') 
        {
            switch ($this->db->dbdriver) 
            {
                case 'mysqli':  $sLimit = "LIMIT ".intval($iDisplayLength)." OFFSET ".intval($iDisplayStart); break;
                case 'sqlsrv':  $sLimit = "OFFSET ".intval($iDisplayStart)." ROWS FETCH NEXT ".intval($iDisplayLength)." ROWS ONLY";
                default:
                    break;
            }
        }

        $uri_string = $_SERVER['QUERY_STRING'];
        $uri_string = preg_replace("/%5B/", '[', $uri_string);
        $uri_string = preg_replace("/%5D/", ']', $uri_string);

        $get_param_array = explode("&", $uri_string);
        $arr = array();
        foreach ($get_param_array as $value) {
            $v = $value;
            $explode = explode("=", $v);
            $arr[$explode[0]] = $explode[1];
        }

        $index_of_columns = strpos($uri_string, "columns", 1);
        $index_of_start = strpos($uri_string, "start");
        $uri_columns = substr($uri_string, 7, ($index_of_start - $index_of_columns - 1));
        $columns_array = explode("&", $uri_columns);
        $arr_columns = array();

        foreach ($columns_array as $value) {
            $v = $value;
            $explode = explode("=", $v);
            if (count($explode) == 2) {
                $arr_columns[$explode[0]] = $explode[1];
            } else {
                $arr_columns[$explode[0]] = '';
            }
        }

        //  Ordering
        $sOrder = "ORDER BY ";
        $sOrderIndex = $arr['order[0][column]'];
        $sOrderDir = $arr['order[0][dir]'];
        $bSortable_ = $arr_columns['columns[' . $sOrderIndex . '][orderable]'];
        if ($bSortable_ == "true") {

            $sColumn = $data['columns'][$sOrderIndex];

            if( strpos($sColumn, ' as ' ) ) {
                $aliased = explode(' as ', $sColumn);
                $sColumn = $aliased[1];
            }

            $sOrder .= $sColumn . ($sOrderDir === 'asc' ? ' asc' : ' desc');
        }

        //  Filtering
        $sWhere = null;

        if ( !is_null($data['where']) )
            $sWhere = $data['where'];

        $sSearchVal = $arr['search[value]'];
        if (isset($sSearchVal) && $sSearchVal != '') 
        {
            $sWhere = ( strlen($sWhere)>0 ) ? " ".$sWhere . " AND (" : " WHERE (";

            for ($i = 0; $i < count($data['columns']); $i++)
            {
				
				if(substr($data['columns'][$i],0,3) != "SUM" && substr($data['columns'][$i],0,3) != "AVG" && substr($data['columns'][$i],0,3) != "MIN" && substr($data['columns'][$i],0,3) != "MAX"   )
				{
					$sWhere .= $data['columns'][$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR ";
				}

                if( strpos($data['columns'][$i], ' as ') ) {
                    $aliased = explode(' as ', $data['columns'][$i]);
                    $data['columns'][$i] = $aliased[1];
				}
			}
		
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        //  Individual column filtering
        $sSearchReg = $arr['search[regex]'];

        for ($i = 0; $i < count($data['columns']); $i++) 
        {
            $bSearchable_ = $arr['columns[' . $i . '][searchable]'];

            if (isset($bSearchable_) && $bSearchable_ == "true" && $sSearchReg != 'false') 
            {
                $search_val = $arr['columns[' . $i . '][search][value]'];

                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }

                $sWhere .= $data['columns'][$i]." LIKE '%".$this->db->escape_like_str($search_val)."%' ";
            }
        }

        //  Get data to display
        $sQuery = "SELECT (SELECT COUNT( ".$aggregate." ".$data['index'].") FROM ".$data['object']." ".$data['where'].") AS row_count, " . str_replace(" , ", " ", implode(", ", $data['columns'])) . " FROM " . $data['object']." ".$data['join']." ".(str_replace('+', ' ', $sWhere))." ".$data['group']." ".$sOrder." ".$sLimit;
		
        // echo $sQuery; die();

        $rResult = $this->db->query($sQuery);
		
        //  Data set length after filtering
        $rResultFilterTotal = $this->db->query($sQuery);
		
        if( $rResultFilterTotal->num_rows() > 0 )
            $iFilteredTotal = $rResultFilterTotal->row()->row_count;
        else
            $iFilteredTotal = 0;

        //  Output
		$sEcho = $this->input->get_post('draw', true);
		
        $output = array(
            "draw" => intval($sEcho),
            "recordsTotal" => $iTotal,
            "recordsFiltered" => $iFilteredTotal,
            "data" => array()
        );

        foreach ($rResult->result_array() as $aRow) 
        {
            $row = array();
            
            foreach ($data['columns'] as $col) 
            {
				
				
                if( strpos( $col, ' AS ') )
                {
                    $aliased = explode(' AS ', $col);
                    $col = $aliased[1];
                } 
                else 
                {
					
                    if( strpos($col, '.') ) {
                        $prefixed = explode('.', $col);
                        $col = $prefixed[1];
                    }

                    $col = str_replace('[', '', $col);
                    $col = str_replace(']', '', $col);
                }

                $row[] = $aRow[$col];
            }
			$output['data'][] = $row;
			
        }
		// var_dump($output['data']);
		// exit();
        return $output;
    }


    /**
     *  Enhanced and shortened form of the Codeigniter active record fetching an array of result
     *  @param $args1 (string)     = The name of object or table
     *  @param $args2 (array)       = The CI array foriming the where clause(s)
     *  @param $database (string)   = The database source
     */
    protected function resultArray( $args1=null, $args2=null, $database=null )
    {
        $this->selectDatabase( $database );

        $result = false;

        if( !is_object($args1) )
        {
            if( $args1 ) {
                if( $args2 )
                    $args1 = $this->db->get_where( $args1, $args2 );
                else
                    $args1 = $this->db->get( $args1 );
            } else {
                $args1 = $this->db->get();
            }
        }
        else
        {
            if( $args2 ) 
                $result = $args2;
        }

        if( $args1->num_rows() > 0 )
            return $args1->result_array();

        return $result;
    }


    /**
     *  Add index and value to an existing object/array. Used only when fetching single record
     *  @param $result (array)  = The array to be appended with new index and value
     *  @param $data (array)    = a set of array containing index name and value
     *  @return array
     *
     *  ADDED: 2017-03-14 RLSC
     */
    protected function resultArrayAppend( $result=null, $data=null )
    {
        if( is_array($result) && is_array($data) )
        {
            foreach( $data as $row ) {
                $result[0][$row['index']] = $row['value'];
            }

            return $result;
        }

        return false;
    }


    /**
     *  Enhanced and shortened form of the Codeigniter active record fetching a single row of result
     *  @param $row (string)        = The name or alias of the selected row
     *  @param $database (string)   = The database source
     *  @return array
     */
    protected function resultRow( $row=null, $database=null )
    {
        $this->selectDatabase( $database );

        $result = $this->db->get();

        if( $result->num_rows() > 0 )
            if( $row )
                return $result->row()->$row;
            else
                return 0;

        return false;
    }


    protected function resultObjectRow( $result=null, $row=string, $database=null )
    {
        $this->selectDatabase( $database );

        if( $result->num_rows() > 0 )
            if( $row )
                return $result->row()->$row;
            else
                return 0;

        return false;
    }


    /**
     *  Check if a record already exist based on the set of condition given in the secon argument
     *  @param $object (string) = The name of object or table
     *  @param $data (array)    = a set of array patterned after CI where clause
     */
    protected function checkExistingRecord( $object=string, $data=array() )
    {
        $this->db = $this->selectDatabase( $database );

        $result = $this->db->get_where( $object, $data );

        if( $result->num_rows() > 0 )
            return true;

        return false;
    }



    protected function commonErrorResponse()
    {
        return array(
                'result'    => 'error',
                'header'    => 'FAILED',
                'message'   => 'The system cannot process your request.',
            );
    }



    public function get_record( $object=null, $column=null, $key=array() )
    {
        $this->db->select($column)->from($object)->where($key);

        return $this->resultRow($column);
    }



    public function run_session_query()
    {
        $query_string = $this->session->userdata('QUERY');

        if( !is_null($query_string) )
        {
            $query = $this->db->query( $query_string );

            return $this->resultArray($query);
        }

        return false;
    }
}
