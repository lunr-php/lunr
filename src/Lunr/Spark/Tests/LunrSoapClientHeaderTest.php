<?php

/**
 * This file contains the LunrSoapClientSetTest class.
 *
 * @package    Lunr\Spark
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Tests;

use SoapHeader;
use SoapFault;

/**
 * This class contains tests for the header functions of the LunrSoapClient class.
 *
 * @covers Lunr\Spark\LunrSoapClient
 */
class LunrSoapClientHeaderTest extends LunrSoapClientTest
{

    /**
     * Test that __construct initializes headers array.
     *
     * @covers Lunr\Spark\LunrSoapClient::__construct
     */
    public function testConstructInitializesHeaders(): void
    {
        $this->assertPropertySame('headers', []);
    }

    /**
     * Test create_header() creates a header.
     *
     * @covers Lunr\Spark\LunrSoapClient::create_header
     */
    public function testCreateHeaderCreatesHeader(): void
    {
        $namespace = 'ns';
        $name      = 'name';
        $data      = [ 'data' ];

        $result = $this->class->create_header($namespace, $name, $data);

        $expected_header = new SoapHeader($namespace, $name, $data);

        $this->assertEquals($expected_header, $result);
    }

    /**
     * Test set_headers() sets client headers.
     *
     * @covers Lunr\Spark\LunrSoapClient::set_headers
     */
    public function testSetHeadersSetsSingleHeader(): void
    {
        $header = new SoapHeader('ns1', 'name1', [ 'data1' ]);

        $this->class->set_headers($header);

        $this->assertPropertySame('headers', [ $header ]);
    }

    /**
     * Test set_headers() sets client headers.
     *
     * @covers Lunr\Spark\LunrSoapClient::set_headers
     */
    public function testSetHeadersSetsMultipleHeaders(): void
    {
        $headers = [
            new SoapHeader('ns1', 'name1', [ 'data1' ]),
            new SoapHeader('ns2', 'name2', [ 'data2' ]),
        ];

        $this->class->set_headers($headers);

        $this->assertPropertySame('headers', $headers);
    }

    /**
     * Test set_headers() unsets client headers.
     *
     * @covers Lunr\Spark\LunrSoapClient::set_headers
     */
    public function testSetHeadersUnsetsHeadersWithNull(): void
    {
        $headers = [
            new SoapHeader('ns1', 'name1', [ 'data1' ]),
            new SoapHeader('ns2', 'name2', [ 'data2' ]),
        ];

        $this->set_reflection_property_value('headers', $headers);

        $this->class->set_headers(NULL);

        $this->assertPropertySame('headers', []);
    }

    /**
     * Test set_headers() returns a self reference.
     *
     * @covers Lunr\Spark\LunrSoapClient::set_headers
     */
    public function testSetHeadersReturnsSelfReference(): void
    {
        $value = $this->class->set_headers([]);

        $this->assertInstanceOf('Lunr\Spark\LunrSoapClient', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test get_headers() unsets client headers.
     *
     * @covers Lunr\Spark\LunrSoapClient::set_headers
     */
    public function testGetHeadersReturnsHeaders(): void
    {
        $headers = [
            new SoapHeader('ns1', 'name1', [ 'data1' ]),
            new SoapHeader('ns2', 'name2', [ 'data2' ]),
        ];

        $this->set_reflection_property_value('headers', $headers);

        $value = $this->class->get_headers();

        $this->assertSame($value, $headers);
    }

    /**
     * Test __soapCall() resets client headers.
     *
     * @covers Lunr\Spark\LunrSoapClient::__soapCall
     */
    public function testSoapCallResetsHeaders()
    {
        $headers = [
            new SoapHeader('ns1', 'name1', [ 'data1' ]),
            new SoapHeader('ns2', 'name2', [ 'data2' ]),
        ];

        $this->set_reflection_property_value('headers', $headers);

        try
        {
            $this->class->__soapCall('foo', []);
        }
        catch (SoapFault $e)
        {
            $this->assertPropertySame('headers', []);
        }
    }

}

?>
