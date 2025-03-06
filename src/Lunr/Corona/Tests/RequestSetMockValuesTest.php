<?php

/**
 * This file contains the RequestSetMockValuesTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers Lunr\Corona\Request
 */
class RequestSetMockValuesTest extends RequestTestCase
{

    /**
     * Test setMockValues() sets values correctly.
     *
     * @covers Lunr\Corona\Request::setMockValues
     */
    public function testSetMockValues(): void
    {
        $mock = [ 'controller' => 'newcontroller' ];

        $this->class->setMockValues($mock);

        $this->assertEquals([ $mock ], $this->getReflectionPropertyValue('mock'));
    }

}

?>
