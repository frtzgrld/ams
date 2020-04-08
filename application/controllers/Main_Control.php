<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 |  Main_Control.php
 |  This will be the system's main controller. All controllers inside the 'application/modules' folder 
 |  (as well as other controllers inside the 'application/controllers' folder), must extend this
 |  controller in order to access the system's main functionalities
 |  
 */

Class Main_Control extends MX_Controller 
{
    var $ob_level;

    /**
     *  All preloaded models, helpers, etc. will also be inherited by children classes
     */
	function __construct()
    {
        parent::__construct();

        $this->ob_level = ob_get_level();

        //  Load main/top level model
        $this->load->model('Main_Model');
        // $this->load->model('offices/office_model');
        $this->load->model('users/users_model');

        //  Load custom libraries
        $this->load->library('form_validation');

        //  Load custom_helpers
        $this->load->helper('asset_management_helper');

        //  Load custom configs
        $this->config->load('custom_configs');

        define('404', 'SHOW 404');
    }

    protected function index()
    {
        //  further enhancement
        echo 'Main Controller';
    }

    /**
     |  THE ACCESSIBILITY-RELATED METHODS
     |
     |  The ff. functions are used to validate the accessibility of a user to entire parts of the system.
     |  Most of these functions requires the correct prerequisite data designed in the database for:
     |      - Access Rights ( a database table )     
     |      - Transaction Codes ( a database table )
     |      - name of php files to be used
     */

    /**
     *  This method is used to check if a user has active session
     *  NEED FURTHER ENHANCEMENT
     */
    protected function checklog()
    {
    	if( $this->session->userdata('ROLECODE') == null )
    		redirect( base_url('login') );
    }


    /**
     *  This method determines the accessibility to a specific operation for a specific module
     *  @param $module (string) = the target module; passed from method calling constant name 
     *      defined in config/constants.php or from the class itself
     *  @param $operation (string) = the target operation:
     *          r   = read/view                     c   = create/insert operation
     *          u   = update/edit operation         d   = delete operation
     *          a   = activate                      i   = deactivate/cancel
     *          p   = print
     *  @return Boolean
     */
    protected function check_permissions( $module=null, $operation='R' ) {
        // return true; // comment this line if not in development
        
        if ( $module )
        {
            if( $this->Main_Model->getAccessRights($module, $operation) ) // || $this->Main_Model->getUserPermission($module, $operation))
            {
                return true;
            }
        }
        
        //  buffer the error page if not met the above requirements
        $this->get_permission_error();
    }

    /**
     *  This method (and the proceding one) generates the permission error page (403 Access Denied)
     *      once the user is accessing a page or a process that is not part of his rights
     *  @return string
     */
    protected function get_permission_error()
    {
        echo $this->show_permission_error();
        exit;
    }


    protected function show_permission_error()
    {
        if (ob_get_level() > $this->ob_level + 1)
        {
            ob_end_flush();
        }
        
        ob_start();
        include(APPPATH.'views/errors/html/error_403.php');
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }

    protected function get_service_unavailable()
    {
        echo $this->show_service_unavailable();
        exit;
    }

    protected function show_service_unavailable()
    {
        if (ob_get_level() > $this->ob_level + 1)
        {
            ob_end_flush();
        }
        
        ob_start();
        include(APPPATH.'views/errors/html/error_503.php');
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }


    /**
     |  THE LAYOUT METHODS
     |
     |  The ff. functions are used for presentation purpose.
     */

    /**
     *  Return the page designed for a user group over the entire system
     *  @param $pages (string/array) = contains the directory of the requested view file
     *  @param $data (array) = passed value
     *  @param $layout (string) = page layout type; 'system' is the default value
     *  @return html
     */
    protected function get_view( $pages='blank', $data=array(), $layout='system' )
    {
        switch( $layout )
        {
            case 'public':
                    $this->load->view('public/public_header', $data );
                    $this->load->view('public/public_navbar');
                    $this->load_pages( $pages );
                    $this->load->view('public/public_footer');
                break;

            case 'system':
            default:
                    $this->load->view('includes/header', $data );
                    $this->load->view('includes/topbar');
                    $this->load->view('includes/sidebar');
                    $this->load_pages( $pages );
                    $this->load->view('includes/footer');
                break;
        }

        return ob_get_contents(); //  this can also be removed
    }

    //  associated to get_view()
    private function load_pages( $pages )
    {
        if( is_array($pages) ) {
            for( $a=0; $a<count($pages); $a++ ) {
                $this->load->view( $pages[$a] );
            }
        } else {
            $this->load->view( $pages );
        }
    }
    
    
    /**  
     |  THE BUFFER METHODS
     |  The purpose of the ff. methods is simply to redirect or display error messages
     |      due to incompleteness of value needed or non-existence of a record
     |      as a result of generation of information taken from passed values via GET or POST method
     */

    /**
     *  Redirect to a specified header if the first argument failed
     *  @param $segment (string) = the uri segment
     *  @param $redirect_to (string) = the location to redirect
     *  @return void
     */
    protected function revert( $segment='', $redirect_to='login' )
    {
        if( $segment == '' )
            redirect( base_url() . $redirect_to );
    }

    /**
     *  Respond accordingly to the content of data (response) passed. 
     *  @param $response (array) = passed response of a model method called
     *  @param $error_msg (string) = display error message
     *  @param $in_list (array) = provide list of accepted key word
     *  @return void
     */
    protected function respond( $response=null, $error_msg='default', $in_list=null )
    {
        if( $response )
        {
            if( $in_list )
            {
                $exist = 0;
                
                for ($i=0; $i < count($in_list); $i++) 
                {
                    if( $response == $in_list[$i] ) {
                        $exist++;
                    }
                }

                if( $exist > 0 )
                    return;
                else
                    show_404();
            }

            return;
        }
        else
        {
            if( $error_msg == 'default' )
                show_404();
            else
                echo $this->show_error_msg( $error_msg );
        }
            
        exit();
    }

    protected function react( $segment_value='', $return_buffer)
    {
        if( $segment_value )
            return $segment_value;
        else
            switch ($return_buffer) 
            {
                case 'SHOW 404':
                default:
                    show_404();
                    break;
            }
    }

    protected function show_error_msg( $error_msg=string )
    {
        ob_start();
        include( APPPATH . 'views/errors/html/error_general.php' );
        // include( APPPATH . 'views/errors/html/error_general/' . $error_msg . '.php' );
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }


    protected function invalid_action()
    {
        return array(
                'result'    => 'warning',
                'header'    => 'ERROR CODE: 1010',
                'message'   => 'The system can\'t process the request due to incorrect action stated. Consult the administrator.',
            );
    }

    /**
     *  Check if the request is an XMLHttpRequest (XHR)
     *  Used in restricting to direct URL access of a method that can only be accessed thru AJAX 
     */
    protected function xhr()
    {
        if( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) 
            == 'xmlhttprequest' )
            return true;
        else
            $this->get_permission_error();
    }
}
