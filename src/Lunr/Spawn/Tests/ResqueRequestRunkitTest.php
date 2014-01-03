<?php

/**
 * This file contains the ResqueRequestRunkitTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

/**
 * Tests for getting stored superglobal values.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spawn\ResqueRequest
 */
class ResqueRequestRunkitTest extends ResqueRequestTest
{

    /**
     * Runkit simulation code for getting the hostname.
     * @var string
     */
    const GET_HOSTNAME = 'return "Lunr";';

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        if (extension_loaded('runkit') === FALSE)
        {
            $this->markTestSkipped('Extension runkit is required.');
        }

        $this->mock_function('gethostname', self::GET_HOSTNAME);

        parent::setUp();
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        $this->unmock_function('gethostname');
    }

    /**
     * Test that the hostname is stored correctly in the constructor.
     */
    public function testHostnameIsSet()
    {
        $request = $this->get_reflection_property_value('request');

        $this->assertArrayHasKey('host', $request);
        $this->assertEquals('Lunr', $request['host']);
    }

    /**
     * Test that the hostname value is returned correctly by the magic get method.
     */
    public function testGetHostname()
    {
        $this->assertEquals('Lunr', $this->class->host);
    }

}

?>
