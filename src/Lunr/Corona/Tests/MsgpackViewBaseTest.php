<?php

/**
 * This file contains the MsgpackViewBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package   Lunr\Corona
 * @author    Patrick Valk <p.valk@m2mobi.com>
 * @copyright 2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the MsgpackView class.
 *
 * @covers     Lunr\Corona\MsgpackView
 */
class MsgpackViewBaseTest extends MsgpackViewTest
{

    /**
     * Test that the Request class is passed correctly.
     */
    public function testRequestIsPassedCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the Response class is passed correctly.
     */
    public function testResponseIsPassedCorrectly()
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the Configuration class is passed correctly.
     */
    public function testConfigurationIsPassedCorrectly()
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

    /**
     * Test that prepare_data() does not modify the data.
     *
     * @covers Lunr\Corona\MsgpackView::prepare_data
     */
    public function testPrepareDataReturnsUnmodifiedData()
    {
        $data = [ 'key' => 'value', 'key2' => NULL ];

        $method = $this->get_accessible_reflection_method('prepare_data');

        $this->assertSame($data, $method->invokeArgs($this->class, [ $data ]));
    }

}

?>
