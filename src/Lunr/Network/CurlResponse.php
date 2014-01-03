<?php

/**
 * This file wraps response data from a Curl request.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Curl
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network;

/**
 * Curl response data wrapper class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Curl
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class CurlResponse
{

    use NetworkErrorTrait;

    /**
     * Information about a successfully completed request.
     * @var array
     */
    protected $info;

    /**
     * Curl request result.
     * @var mixed
     */
    protected $result;

    /**
     * Constructor.
     *
     * @param mixed    $result Request result
     * @param resource $handle Curl request resource handle
     */
    public function __construct($result, $handle)
    {
        $this->result = $result;

        if ($result === NULL)
        {
            $this->error_number  = -1;
            $this->error_message = 'Could not set curl options!';
        }
        else
        {
            $this->error_number  = curl_errno($handle);
            $this->error_message = curl_error($handle);
            $this->info          = curl_getinfo($handle);
        }

        if (!is_array($this->info))
        {
            $this->info = [];
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->error_number);
        unset($this->error_message);
        unset($this->info);
        unset($this->result);
    }

    /**
     * Get access to certain private attributes.
     *
     * This gives access to request info.
     *
     * @param String $name Attribute name
     *
     * @return mixed $return Value of the chosen attribute
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->info))
        {
            return $this->info[$name];
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Get the request result.
     *
     * @return mixed $result Request result
     */
    public function get_result()
    {
        return $this->result;
    }

}

?>
