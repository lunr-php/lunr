<?php

/**
 * This file contains the BadRequestExceptionBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions\Tests;

/**
 * This class contains tests for the BadRequestException class.
 *
 * @covers Lunr\Corona\Exceptions\BadRequestException
 */
class BadRequestExceptionBaseTest extends BadRequestExceptionTest
{

    /**
     * Test that the error code was set correctly.
     */
    public function testErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('code', 400);
    }

    /**
     * Test that the error code was set correctly.
     */
    public function testApplicationErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('app_code', $this->code);
    }

    /**
     * Test that the input data value was set correctly.
     */
    public function testInputDataValueIsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('value'));
    }

    /**
     * Test that the input data flag was set correctly.
     */
    public function testDefaultDataAvailableIsFalse(): void
    {
        $this->assertFalse($this->class->isDataAvailable());
    }

    /**
     * Test that the error message was passed correctly.
     */
    public function testErrorMessagePassedCorrectly(): void
    {
        $this->expectExceptionMessage($this->message);

        throw $this->class;
    }

}

?>
