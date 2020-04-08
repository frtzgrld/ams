<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	asset_management Helpers
 *	This file contains built-in methods that relates to business process of the asset_management
 *	
 *	Load in Main_Control.php
 *	
 *	
 */


if ( ! function_exists('bidding_procedures'))
{
	function bidding_procedures( $proc_mode=null, $slug=null )
	{
		$CI =& get_instance();
		$CI->load->model('Home_Model');
		return $CI->Home_Model->get_procedures( $proc_mode, $slug );
	}
}


if ( ! function_exists('bidding_procedure_column'))
{
	function bidding_procedure_column( $lot_number=null, $procedure_slug=null, $column=null )
	{
		$CI =& get_instance();
		$CI->load->model('bidding_model');

		return $CI->bidding_model->fetch_bidding_matrix_column( $lot_number, $procedure_slug, $column );
	}
}


if ( ! function_exists('procurement_modes'))
{
	function procurement_modes( $condition=null )
	{
		$CI =& get_instance();
		$CI->load->model('procurement/procurement_model');
		return $CI->procurement_model->fetch_procurement_modes( $condition );
	}
}


if ( ! function_exists('nullable') )
{
	function nullable( $field='', $rule=NULL )
	{
		switch ($rule) 
		{
			case 'date':
				$output = ( $field == '' ) ? NULL : date_format( date_create( $field ), 'Y-m-d h:i:s');
				break;
			
			default:
				$output = ( $field == '' ) ? NULL : $field;
				break;
		}

        return $output;
	}
}


if ( ! function_exists('get_max') )
{
	function get_max( $args=array() )
	{
		if($args[0] < $args[1])
			return $args[1];
		elseif ($args[0] > $args[1])
			return $args[0];
		else
			return $args[0];
	}
}


if ( ! function_exists('system_date'))
{
	function system_date( $date='', $format='h' )
	{
		switch ($format) {
			case 's': $date = date_format( date_create($date), 'F d, Y' ); break;
			case 'h':
			default: $date = date_format( date_create($date), 'M d, Y - h:i A' ); break;
		}
		

		return $date;
	}
}


if ( ! function_exists('make_time'))
{
	function make_time( $Y, $M, $D )
	{
		if( !$M )
			return $Y;
		else
			return str_replace('  ', ' ', (date('F', mktime(0, 0, 0, $M, 10))).' '.$D.' '.$Y);
	}
}


if( ! function_exists('ordinal') )
{
	function ordinal($number) 
	{
	    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
	    if ((($number % 100) >= 11) && (($number%100) <= 13))
	        return $number. 'th';
	    else
	        return $number. $ends[$number % 10];
	}
}

if( ! function_exists('profile') )
{
	function profile( $key_name, $key_value, $target_column ) 
	{
		$CI =& get_instance();
		$CI->load->model('account/user_model');
	    return $CI->user_model->get_user_profile( $key_name, $key_value, $target_column );
	}
}

if( ! function_exists('procurement_link') )
{
	function procurement_link( $mode ) 
	{
		$CI =& get_instance();
		$CI->load->model('procurement/procurement_model');
	    return $CI->procurement_model->procurement_link( $mode );
	}
}

if( ! function_exists('office_list') )
{
	function office_list( $not_in=false ) 
	{
		$CI =& get_instance();
		$CI->load->model('offices/office_model');
	    return $CI->office_model->office_list( $not_in );
	}
}

if( ! function_exists('user_offices') )
{
	function user_offices( $where_array=null, $join_refference=false, $as_array_index=null ) 
	{
		$CI =& get_instance();
		$CI->load->model('account/user_model');
	    return $CI->user_model->user_offices( $where_array, $join_refference, $as_array_index );
	}
}

if( ! function_exists('select_items') )
{
	function select_items( $category=null, $leafonly=false, $item_id=null ) 
	{
		$CI =& get_instance();
		$CI->load->model('items/items_model');
	    return $CI->items_model->get_options_items( $category, $leafonly, $item_id );
	}
}

if( ! function_exists('disposal_type') )
{
	function disposal_type() 
	{
		$CI =& get_instance();
		$CI->load->model('items/inventory_model');
	    return $CI->inventory_model->get_disposal_types();
	}
}

if( ! function_exists('document') )
{
	function document( $document=null, $designation=null, $display='FULLNAME' ) 
	{
		$CI =& get_instance();
		$CI->load->model('offices/office_model');
	    return $CI->office_model->get_document_signatory($document, $designation, $display);
	}
}

if( ! function_exists('office_heads') )
{
	function office_heads( $id=null ) 
	{
		$CI =& get_instance();
		$CI->load->model('offices/office_model');
	    return $CI->office_model->get_office_heads($id);
	}
}


if( ! function_exists('allotments') )
{
	function allotments( $id=null ) 
	{
		$CI =& get_instance();
		$CI->load->model('budget/budget_model');
	    return $CI->budget_model->get_allotments($id);
	}
}


if( ! function_exists('run_session_query') )
{
	function run_session_query() 
	{
		$CI =& get_instance();
		$CI->load->model('Main_Model');
	    return $CI->Main_Model->run_session_query();
	}
}

?>