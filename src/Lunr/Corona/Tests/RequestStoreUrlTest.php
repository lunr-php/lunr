<?php

/**
 * This file contains the RequestStoreUrlTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for storing superglobal values.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @author        Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers        Lunr\Corona\Request
 * @backupGlobals enabled
 */
class RequestStoreUrlTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpEmpty();
    }

    /**
     * Test that the base_path is constructed and stored correctly.
     *
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStoreBasePath()
    {
        $method = $this->get_accessible_reflection_method('store_url');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals('/path/to/', $request['base_path']);
    }

    /**
     * Test that the domain is stored correctly.
     *
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStoreDomain()
    {
        $method = $this->get_accessible_reflection_method('store_url');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals('www.domain.com', $request['domain']);
    }

    /**
     * Test that the port is stored correctly.
     *
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStorePort()
    {
        $method = $this->get_accessible_reflection_method('store_url');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals('443', $request['port']);
    }

    /**
     * Test that the protocol is constructed and stored correctly.
     *
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStorePortIfHttpsUnset()
    {
        $_SERVER = $this->setup_server_superglobal();
        unset($_SERVER['HTTPS']);

        $method = $this->get_accessible_reflection_method('store_url');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals('http', $request['protocol']);
    }

    /**
     * Test that the protocol is constructed and stored correctly.
     *
     * @param String $value    HTTPS value
     * @param String $protocol Protocol according to the HTTPS value
     *
     * @dataProvider httpsServerSuperglobalValueProvider
     * @covers       Lunr\Corona\Request::store_url
     */
    public function testStorePortIfHttpsIsset($value, $protocol)
    {
        $_SERVER          = $this->setup_server_superglobal();
        $_SERVER['HTTPS'] = $value;

        $method = $this->get_accessible_reflection_method('store_url');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals($protocol, $request['protocol']);
    }

    /**
     * Test that the protocol is constructed and stored correctly.
     *
     * @param String $https HTTPS value
     * @param String $port  Port for the webserver
     * @param String $value The expected base_url value
     *
     * @dataProvider baseurlProvider
     * @covers       Lunr\Corona\Request::store_url
     */
    public function testStoreBaseUrl($https, $port, $value)
    {
        $_SERVER                = $this->setup_server_superglobal();
        $_SERVER['HTTPS']       = $https;
        $_SERVER['SERVER_PORT'] = $port;

        $method = $this->get_accessible_reflection_method('store_url');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals($value, $request['base_url']);
    }

}

?>
