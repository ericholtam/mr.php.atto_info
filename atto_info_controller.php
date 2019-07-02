<?php

/**
 * ATTO Info module class
 *
 * @package munkireport
 * @author
 **/
class Atto_info_controller extends Module_controller
{
    
    /*** Protect methods with auth! ****/
    public function __construct()
    {
        // Store module path
        $this->module_path = dirname(__FILE__);
    }

    /**
     * Default method
     *
     * @author AvB
     **/
    public function index()
    {
        echo "You've loaded the ATTO Info module!";
    }
    
    /**
     * Get ATTO Info for serial_number
     *
     * @param string $serial serial number
     **/
    public function get_data($serial = '')
    {

        $out = array();
        if (! $this->authorized()) {
            $out['error'] = 'Not authorized';
        } else {
            $atto = new Atto_info_model;
            foreach ($atto->retrieve_records($serial) as $atto_info) {
                $out[] = $atto_info->rs;
            }
        }
        
        $obj = new View();
        $obj->view('json', array('msg' => $out));
    }

} // END class default_module
