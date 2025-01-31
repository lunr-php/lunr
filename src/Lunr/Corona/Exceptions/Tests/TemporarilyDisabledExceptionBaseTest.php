<?php

/**
 * This file contains the TemporarilyDisabledExceptionBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions\Tests;

/**
 * This class contains tests for the TemporarilyDisabledException class.
 *
 * @covers Lunr\Corona\Exceptions\TemporarilyDisabledException
 */
class TemporarilyDisabledExceptionBaseTest extends TemporarilyDisabledExceptionTestCase
{

    /**
     * Test that the error code was set correctly.
     */
    public function testErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('code', 540);
    }

    /**
     * Test that the error code was set correctly.
     */
    public function testApplicationErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('app_code', $this->code);
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
