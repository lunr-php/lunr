<?php

/**
 * This file contains the LunrSoapClient class.
 *
 * @package    Lunr\Spark
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

use SoapClient;
use SoapHeader;

/**
 * Wrapper around SoapClient class.
 */
class LunrSoapClient extends SoapClient
{

    /**
     * Headers set for the next request.
     * @var array
     */
    protected $headers;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->headers = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->headers);
    }

    /**
     * Inits the client.
     *
     * @param string $wsdl    WSDL url
     * @param array  $options SOAP client options
     *
     * @return LunrSoapClient Self reference
     */
    public function init($wsdl, $options)
    {
        parent::__construct($wsdl, $options);
        return $this;
    }

    /**
     * Create a SoapHeader.
     *
     * @param string $namespace Header namespace
     * @param string $name      Header name
     * @param array  $data      Header data
     *
     * @return SoapHeader header created
     */
    public function create_header($namespace, $name, $data)
    {
        return new SoapHeader($namespace, $name, $data);
    }

    /**
     * Set the client headers.
     *
     * @param array|SoapHeader|null $headers Headers to set
     *
     * @return LunrSoapClient Self reference
     */
    public function set_headers($headers = NULL)
    {
        if ($this->__setSoapHeaders($headers) === TRUE)
        {
            if ($headers === NULL)
            {
                $this->headers = [];
            }
            elseif (!is_array($headers))
            {
                $this->headers = [ $headers ];
            }
            else
            {
                $this->headers = $headers;
            }
        }

        return $this;
    }

    /**
     * Get the client headers.
     *
     * @return array Array of SoapHeader classes for the next request
     */
    public function get_headers()
    {
        return $this->headers;
    }

    /**
     * Calls a SOAP function
     *
     * This is a low level API function that is used to make a SOAP call.
     * Usually, in WSDL mode, SOAP functions can be called as methods of the
     * SoapClient object. This method is useful in non-WSDL mode when
     * soapaction is unknown, uri differs from the default or when sending
     * and/or receiving SOAP Headers.
     *
     * @param string $function_name The name of the SOAP function to call.
     * @param array  $arguments     An array of the arguments to pass to the function.
     * @param array  $options       An associative array of options to pass to the client.
     * @param mixed  $input_headers An array of headers to be sent along with the SOAP request.
     * @param array $output_headers If supplied, this array will be filled with the headers from the SOAP response.
     *
     * @return mixed Single value or array of values
     **/
    public function __soapCall($name, $args, $options = NULL, $inputHeaders = NULL, &$outputHeaders = NULL)
    {
        $this->headers = [];
        return parent::__soapCall($name, $args, $options, $inputHeaders, $outputHeaders);
    }

}

?>
