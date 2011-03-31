<?php

/**
 * This file contains a Curl wrapper class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * Curl Class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Curl
{

    /**
     * Curl options array
     * @var array
     */
    private $options;

    /**
     * Information about a successfully completed request
     * @var array
     */
    private $info;

    /**
     * Curl error number
     */
    private $errno;

    /**
     * Curl error message
     */
    private $errmsg;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $options = array();

        // set default curl options
        $this->options[CURLOPT_TIMEOUT]        = 30;
        $this->options[CURLOPT_RETURNTRANSFER] = TRUE;
        $this->options[CURLOPT_FOLLOWLOCATION] = TRUE;
        $this->options[CURLOPT_FAILONERROR]    = TRUE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->options);
    }

    /**
     * Set multiple curl config options at once.
     *
     * @param array $options Array of curl config options
     *
     * @return Boolean $return TRUE if it was stored successfully
     *                         FALSE if the input is not an array
     */
    public function set_options($options)
    {
        if (!is_array($options))
        {
            return FALSE;
        }

        $this->options = $options + $this->options;

        return TRUE;
    }

    /**
     * Set a curl config option.
     *
     * @param String $key   Name of a curl config key (minus 'CURLOPT_')
     * @param mixed  $value Value of that config options
     *
     * @return void
     */
    public function set_option($key, $value)
    {
        if (is_string($key) && !is_numeric($key))
        {
            $key = constant('CURLOPT_' . strtoupper($key));
        }

        $this->options[$key] = $value;
    }

    /**
     * Temporary simple call to retrieve remote content.
     *
     * @param String $location remote location
     *
     * @return mixed $return Value
     */
    public function simple_get($location)
    {
        $res = curl_init($location);

        if (!curl_setopt_array($res, $this->options))
        {
            $this->errmsg = "Could not set curl options!";
            return FALSE;
        }

        $return = curl_exec($res);

        if ($return === FALSE)
        {
            $this->errno  = curl_errno($res);
            $this->errmsg = curl_error($res);

            curl_close($res);

            return $return;
        }
        else
        {
            $this->info = curl_getinfo($res);

            curl_close($res);

            return $return;
        }
    }

}

?>
