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
     * @param string $wsdl    WSDL url
     * @param array  $options SOAP client options
     *
     * @return LunrSoapClient Self reference
     */
    public function init(string $wsdl, array $options): self
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
     * @return SoapHeader Header created
     */
    public function create_header(string $namespace, string $name, array $data): SoapHeader
    {
        return new SoapHeader($namespace, $name, $data);
    }

    /**
     * Set the client headers.
     *
     * @param array|SoapHeader|null $headers Headers to set
     *
     * @return static Self reference
     */
    public function set_headers($headers = NULL)
    {
        $this->__setSoapHeaders($headers);

        return $this;
    }

}

?>
