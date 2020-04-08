<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 |	form_validation.php
 |	configured [config file] containing (at least) all of the form validations in the entire application.
 |*/

$config = array(

        'system_login'  => array(
                array(
                        'field' => 'username',
                        'label' => 'Username',
                        'rules' => 'required|trim|max_length[20]|min_length[5]'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'required|trim|max_length[100]|min_length[5]'
                ),
            ),

		'purchase_request'	=> array(
                array(
                        'field' => 'pr_office',
                        'label' => 'Office name',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'pr_purpose',
                        'label' => 'Purpose',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'pr_requested_by',
                        'label' => 'Name of requestor',
                        'rules' => ''
                ),
                array(
                        'field' => 'pr_date',
                        'label' => 'Date of request',
                        'rules' => 'required'
                ),
            ),

	);

?>