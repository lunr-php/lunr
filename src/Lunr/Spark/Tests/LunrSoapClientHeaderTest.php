<?php

/**
 * This file contains the LunrSoapClientSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
    public function testSetHeadersSetsHeaders(): void
    {
        $headers = [
            new SoapHeader('ns1', 'name1', [ 'data1' ]),
            new SoapHeader('ns2', 'name2', [ 'data2' ]),
        ];

        $this->class->set_headers($headers);

        if (PHP_MAJOR_VERSION >= 8 && PHP_MINOR_VERSION >= 1)
        {
            $parent = $this->reflection->getParentClass();

            $default_headers = $parent->getProperty('__default_headers');
            $default_headers->setAccessible(TRUE);

            $value = $default_headers->getValue($this->class);
            $this->assertCount(2, $value);
        }
        else
        {
            $vars = get_object_vars($this->class);
            $this->assertCount(2, $vars['__default_headers']);
        }
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

}

?>
