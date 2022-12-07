<?php

/**
 * This file contains the RequestAddMockValuesTest class.
 *
 * @package   Lunr\Corona
 * @author    Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright 2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for the add_mock_values function.
 *
 * @covers Lunr\Corona\Request
 */
class RequestAddMockValuesTest extends RequestTest
{

    /**
     * Test add_mock_values() adds values correctly when current mock values are empty.
     *
     * @covers Lunr\Corona\Request::add_mock_values
     */
    public function testAddMockValuesWithCurrentEmpty(): void
    {
        $mock = [ 'controller' => 'new_controller' ];

        $this->set_reflection_property_value('mock', []);

        $this->class->add_mock_values($mock);

        $mock_result = $this->get_reflection_property_value('mock');

        $this->assertEquals($mock, $mock_result);
    }

    /**
     * Test add_mock_values() adds values correctly when current mock values are set.
     *
     * @covers Lunr\Corona\Request::add_mock_values
     */
    public function testAddMockValuesWithCurrentSet(): void
    {
        $current_mock = [
            'controller' => 'old_controller',
            'method'     => 'call',
        ];

        $mock = [ 'controller' => 'new_controller' ];

        $expected_mock = [
            'controller' => 'new_controller',
            'method'     => 'call',
        ];

        $this->set_reflection_property_value('mock', $current_mock);

        $this->class->add_mock_values($mock);

        $mock_result = $this->get_reflection_property_value('mock');

        $this->assertEquals($expected_mock, $mock_result);
    }

}

?>
