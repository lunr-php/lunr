<?php

/**
 * This file contains the DatabaseConnectionBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains the tests for the DatabaseConnection class.
 *
 * @covers Lunr\Gravity\Database\DatabaseConnection
 */
class DatabaseConnectionBaseTest extends DatabaseConnectionTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the Configuration class is passed by reference.
     */
    public function testConfigurationIsPassedByReference(): void
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

    /**
     * Test that the connected flag is set to FALSE by default.
     */
    public function testConnectedIsFalse(): void
    {
        $this->assertFalse($this->get_reflection_property_value('connected'));
    }

    /**
     * Test that the readonly flag is set to TRUE by default.
     */
    public function testReadonlyIsFalseByDefault(): void
    {
        $this->assertFalse($this->get_reflection_property_value('readonly'));
    }

    /**
     * Test that by default we don't have a QueryEscaper instance.
     */
    public function testEscaperIsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('escaper'));
    }

    /**
     * Test that set_readonly sets the readonly flag when passed TRUE.
     *
     * @depends testReadonlyIsFalseByDefault
     * @covers  Lunr\Gravity\Database\DatabaseConnection::set_readonly
     */
    public function testSetReadonlySetsReadonlyWhenPassedTrue(): void
    {
        $this->class->set_readonly(TRUE);

        $this->assertTrue($this->get_reflection_property_value('readonly'));
    }

    /**
     * Test that set_readonly unsets the readonly flag when passed FALSE.
     *
     * @depends testSetReadonlySetsReadonlyWhenPassedTrue
     * @covers  Lunr\Gravity\Database\DatabaseConnection::set_readonly
     */
    public function testSetReadonlySetsReadwriteWhenPassedFalse(): void
    {
        $this->class->set_readonly(TRUE);

        $this->assertTrue($this->get_reflection_property_value('readonly'));

        $this->class->set_readonly(FALSE);

        $this->assertFalse($this->get_reflection_property_value('readonly'));
    }

}

?>
