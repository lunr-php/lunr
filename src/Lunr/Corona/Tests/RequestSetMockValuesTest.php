<?php

/**
 * This file contains the RequestSetMockValuesTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers     Lunr\Corona\Request
 */
class RequestSetMockValuesTest extends RequestTest
{

    /**
     * Check that set_mock_values() does not set values if they are not within an array.
     *
     * @param mixed $value Invalid mock value
     *
     * @dataProvider invalidMockValueProvider
     * @covers       Lunr\Corona\Request::set_mock_values
     */
    public function testSetMockValuesWithInvalidMockValue($value)
    {
        $this->class->set_mock_values($value);

        $this->assertArrayEmpty($this->get_reflection_property_value('mock'));
    }

    /**
     * Test set_mock_values() sets values correctly.
     *
     * @covers Lunr\Corona\Request::set_mock_values
     */
    public function testSetMockValues()
    {
        $mock = [ 'controller' => 'newcontroller' ];

        $this->class->set_mock_values($mock);

        $this->assertEquals($mock, $this->get_reflection_property_value('mock'));
    }

}

?>
