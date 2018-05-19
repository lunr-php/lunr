<?php

/**
 * This file contains the LunrSoapClient class.
 *
 * PHP Version 5.6
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
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }

    /**
     * Inits the client.
     *
     * @param String $wsdl    WSDL url
     * @param Array  $options SOAP client options
     *
     * @return LunrSoapClient $self self reference
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
     * @param array|SoapHeader $headers Headers to set
     *
     * @return LunrSoapClient $self self reference
     */
    public function set_headers($headers)
    {
        $this->__setSoapHeaders($headers);
        return $this;
    }

}

?>
