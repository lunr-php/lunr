<?php

/**
 * This file contains the response abstraction class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;

/**
 * Respone abstraction class.
 * Transport of data between Model/Controller and View
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Response
{

    /**
     * Data store
     * @var array
     */
    private $data;

    /**
     * Error number
     * @var int
     */
    private $errno;

    /**
     * Error message
     * @var String
     */
    private $errmsg;

    /**
     * Additional error info
     * @var String
     */
    private $errinfo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = array();
        $this->errmsg = '';
        $this->errno = 0;
        $this->errinfo = '';
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset($this->data);
        unset($this->errmsg);
        unset($this->errno);
        unset($this->errinfo);
    }

    /**
     * Add response data for later processing by a view
     *
     * @param mixed $key    Identifier for the data
     * @param mixed $value  The data
     *
     * @return void
     */
    public function add_response_data($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Get a specific response data.
     *
     * @param mixed $key Identifier for the data
     *
     * @return mixed $value The matching data on success, or NULL on failure
     */
    public function get_response_data($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : NULL;
    }

    /**
     * Set a return code.
     *
     * @param int $code The return code to set
     *
     * @return void
     */
    public function set_return_code($code)
    {
        if (is_int($code))
        {
            $this->errno = $code;
        }
    }

    /**
     * Get the stored return code.
     *
     * @return int $errno The stored return code
     */
    public function get_return_code()
    {
        return $this->errno;
    }

    /**
     * Set an error message.
     *
     * @param String $msg The error message to store
     *
     * @return void
     */
    public function set_error_message($msg)
    {
        $this->errmsg = $msg;
    }

    /**
     * Get the stored error message.
     *
     * @return String $errmsg The stored error message
     */
    public function get_error_message()
    {
        return $this->errmsg;
    }

    /**
     * Set additional error info.
     *
     * @param String $info Additional info about an error
     *
     * @return void
     */
    public function set_error_info($info)
    {
        $this->errinfo = $info;
    }

    /**
     * Get additional error info,
     *
     * @return String $errinfo Additional error info
     */
    public function get_error_info()
    {
        return $this->errinfo;
    }

}

?>
