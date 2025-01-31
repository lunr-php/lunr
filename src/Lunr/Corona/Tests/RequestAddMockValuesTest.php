<?php

/**
 * This file contains the RequestAddMockValuesTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for the add_mock_values function.
 *
 * @covers Lunr\Corona\Request
 */
class RequestAddMockValuesTest extends RequestTestCase
{

    /**
     * Test add_mock_values() adds values correctly when current mock values are empty.
     *
     * @covers Lunr\Corona\Request::add_mock_values
     */
    public function testAddMockValuesWithCurrentEmpty(): void
    {
        $mock = [ 'controller' => 'new_controller' ];

        $this->setReflectionPropertyValue('mock', []);

        $this->class->add_mock_values($mock);

        $mockResult = $this->getReflectionPropertyValue('mock');

        $this->assertEquals($mock, $mockResult);
    }

    /**
     * Test add_mock_values() adds values correctly when current mock values are set.
     *
     * @covers Lunr\Corona\Request::add_mock_values
     */
    public function testAddMockValuesWithCurrentSet(): void
    {
        $currentMock = [
            'controller' => 'old_controller',
            'method'     => 'call',
        ];

        $mock = [ 'controller' => 'new_controller' ];

        $expectedMock = [
            'controller' => 'new_controller',
            'method'     => 'call',
        ];

        $this->setReflectionPropertyValue('mock', $currentMock);

        $this->class->add_mock_values($mock);

        $mockResult = $this->getReflectionPropertyValue('mock');

        $this->assertEquals($expectedMock, $mockResult);
    }

}

?>
