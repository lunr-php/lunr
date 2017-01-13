<?php

/**
 * This file contains the LunrSoapClientSetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Tests;

use SoapHeader;

/**
 * This class contains tests for the header functions of the LunrSoapClient class.
 *
 * @covers Lunr\Spark\LunrSoapClient
 */
class LunrSoapClientHeaderTest extends LunrSoapClientTest
{

    /**
     * Test create_header creates a header.
     *
     * @covers Lunr\Spark\LunrSoapClient::create_header
     */
    public function testCreateHeaderCreatesHeader()
    {
        $namespace = 'ns';
        $name      = 'name';
        $data      = ['data'];

        $result = $this->class->create_header($namespace, $name, $data);

        $expected_header = new SoapHeader($namespace, $name, $data);

        $this->assertEquals($expected_header, $result);
    }

    /**
     * Test set_headers sets client headers.
     *
     * @covers Lunr\Spark\LunrSoapClient::set_headers
     */
    public function testSetHeadersSetsHeaders()
    {
        $headers = [
            new SoapHeader('ns1', 'name1', ['data1']),
            new SoapHeader('ns2', 'name2', ['data2']),
        ];

        $this->class->set_headers($headers);

        $vars = get_object_vars($this->class);
        $this->assertCount(2, $vars['__default_headers']);
    }

    /**
     * Test set_headers returns a self reference.
     *
     * @covers Lunr\Spark\LunrSoapClient::set_headers
     */
    public function testSetHeadersReturnsSelfReference()
    {
        $value = $this->class->set_headers([]);

        $this->assertInstanceOf('Lunr\Spark\LunrSoapClient', $value);
        $this->assertSame($this->class, $value);
    }

}

?>
