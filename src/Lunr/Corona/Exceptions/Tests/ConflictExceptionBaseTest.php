<?php

/**
 * This file contains the ConflictExceptionBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions\Tests;

/**
 * This class contains tests for the ConflictException class.
 *
 * @covers Lunr\Corona\Exceptions\ConflictException
 */
class ConflictExceptionBaseTest extends ConflictExceptionTestCase
{

    /**
     * Test that the error code was set correctly.
     */
    public function testErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('code', 409);
    }

    /**
     * Test that the error code was set correctly.
     */
    public function testApplicationErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('appCode', $this->code);
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
