<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('has_access'))
{
	function has_access( $tcode=string )
	{
		$CI =& get_instance();

		$CI->load->model('Main_Model');

		$accessibility = $CI->Main_Model->checkAccessibility( $tcode );
		
		return $accessibility;
	}
}
