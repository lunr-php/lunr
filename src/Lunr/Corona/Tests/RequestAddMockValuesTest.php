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
 * Tests for the addMockValues function.
 *
 * @covers Lunr\Corona\Request
 */
class RequestAddMockValuesTest extends RequestTestCase
{

    /**
     * Test addMockValues() adds values correctly when current mock values are empty.
     *
     * @covers Lunr\Corona\Request::addMockValues
     */
    public function testAddMockValuesWithCurrentEmpty(): void
    {
        $mock = [ 'controller' => 'new_controller' ];

        $this->setReflectionPropertyValue('mock', []);

        $this->class->addMockValues($mock);

        $mockResult = $this->getReflectionPropertyValue('mock');

        $this->assertEquals([ $mock ], $mockResult);
    }

    /**
     * Test addMockValues() adds values correctly when current mock values are set.
     *
     * @covers Lunr\Corona\Request::addMockValues
     */
    public function testAddMockValuesWithCurrentSet(): void
    {
        $currentMock = [
            [
                'controller' => 'old_controller',
                'method'     => 'call',
            ],
        ];

        $mock = [ 'controller' => 'new_controller' ];

        $expectedMock = [
            [
                'controller' => 'new_controller',
                'method'     => 'call',
            ],
        ];

        $this->setReflectionPropertyValue('mock', $currentMock);

        $this->class->addMockValues($mock);

        $mockResult = $this->getReflectionPropertyValue('mock');

        $this->assertEquals($expectedMock, $mockResult);
    }

}

?>
