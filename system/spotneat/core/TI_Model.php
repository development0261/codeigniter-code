<?php
/**
 * SpotnEat
 *
 * 
 *
 * @package   SpotnEat
 * @author    Sp
 * @copyright SpotnEat
 * @link      http://spotneat.com
 * @license   http://spotneat.com
 * @since     File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SpotnEat Model Class
 *
 * @category       Libraries
 * @package        SpotnEat\Core\TI_Model.php
 * @link           http://docs.spotneat.com
 */
class TI_Model extends CI_Model {

    public function __construct($config = array())
    {
        $class = str_replace($this->config->item('subclass_prefix'), '', get_class($this));
        log_message('info', $class . '  Model Class Initialized');
    }
}

/* End of file TI_Model.php */
/* Location: ./system/spotneat/core/TI_Model.php */