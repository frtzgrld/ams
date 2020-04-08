<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 |  This config file list custom config 
 |
 |
 |  This config file is loaded once in Main_Control.php
 */       

$config = array(
        
        'bidding_procedure_attachments' => array(
                'upload_path'   => './uploads/', //ASSPATH.'attachments/',
                'allowed_types' => 'jpg|jpeg|png|docx|xlsx|pdf',
                'max_size'      => '400',
                'max_width'     => '400',
                'max_height'    => '400',
            ),

        'custom_months' => array(
                array(
                    'month_number'  => 1,
                    'month_name'    => 'January',
                ),
                array(
                    'month_number'  => 2,
                    'month_name'    => 'February',
                ),
                array(
                    'month_number'  => 3,
                    'month_name'    => 'March',
                ),
                array(
                    'month_number'  => 4,
                    'month_name'    => 'April',
                ),
                array(
                    'month_number'  => 5,
                    'month_name'    => 'May',
                ),
                array(
                    'month_number'  => 6,
                    'month_name'    => 'June',
                ),
                array(
                    'month_number'  => 7,
                    'month_name'    => 'July',
                ),
                array(
                    'month_number'  => 8,
                    'month_name'    => 'August',
                ),
                array(
                    'month_number'  => 9,
                    'month_name'    => 'September',
                ),
                array(
                    'month_number'  => 10,
                    'month_name'    => 'October',
                ),
                array(
                    'month_number'  => 11,
                    'month_name'    => 'November',
                ),
                array(
                    'month_number'  => 12,
                    'month_name'    => 'December',
                ),
            ),
    );

/*  End of textual_values.php
    Location:   ..application/config/textual_values.php
    Created by: RL CRUZ, 4 Nov 2016
    */