<?php

/**
 * This file contains the RequestRunkitTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for getting stored superglobal values.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @covers        Lunr\Corona\Request
 * @backupGlobals enabled
 */
class RequestRunkitTest extends RequestTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpRunkit();
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        parent::tearDownRunkit();
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
