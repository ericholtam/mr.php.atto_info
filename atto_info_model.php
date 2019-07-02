<?php
class Atto_info_model extends \Model
{
    public function __construct($serial = '')
    {
        parent::__construct('id', 'atto_info'); //primary key, tablename
        $this->rs['id'] = '';
        $this->rs['serial_number'] = $serial;
        $this->rs['channel'] = '';
        $this->rs['model'] = '';
        $this->rs['port_state'] = '';
        $this->rs['port_address'] = '';
        $this->rs['driver_version'] = '';
        $this->rs['firmware_version'] = '';
        $this->rs['flash_version'] = '';

        if ($serial) {
            $this->retrieve_record($serial);
        }
        
        $this->serial = $serial;
    }  
    
    // ------------------------------------------------------------------------

    
    /**
     * Process data sent by postflight
     *
     * @param string data
     *
     **/
    public function process($data)
    {
        // Delete previous entries
        $this->deleteWhere('serial_number=?', $this->serial_number);
        
        // Translate printer strings to db fields
        $translate = array(
            'Channel: ' => 'channel',
            'Model: ' => 'model',
            'Port State: ' => 'port_state',
            'Port Address: ' => 'port_address',
            'Driver Version: ' => 'driver_version',
            'Firmware Version: ' => 'firmware_version',
            'Flash Version: ' => 'flash_version');

        //clear any previous data we had
        foreach ($translate as $search => $field) {
            $this->$field = '';
        }
        // Parse data
        foreach (explode("\n", $data) as $line) {
            // Translate standard entries
            foreach ($translate as $search => $field) {
                if (strpos($line, $search) === 0) {
                    $value = substr($line, strlen($search));
                    
                    $this->$field = $value;

                    # Check if this is the last field
                    if ($field == 'flash_version') {
                        $this->id = '';
                        $this->save();
                    }
                    break;
                }
            }
        } //end foreach explode lines
        
    }
}
