<?php

/**
 * This file contains the IniSectionTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Core\Tests;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Ini class.
 *
 * @covers Lunr\Core\Ini
 */
class IniSectionTest extends IniTest
{

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setupSection();
    }

    /**
     * Verify that section is NULL for main ini configuration handling.
     */
    public function testSectionIsNotNull(): void
    {
        $this->assertEquals('date', $this->get_reflection_property_value('section'));
    }

    /**
     * Test setting an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__set
     */
    public function testSettingExistingKey(): void
    {
        ini_set('date.timezone', 'Europe/Amsterdam');

        $this->class->timezone = 'America/Chicago';

        $this->assertEquals('America/Chicago', ini_get('date.timezone'));

        ini_restore('date.timezone');
    }

    /**
     * Test setting a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__set
     */
    public function testSettintNonExistingKey(): void
    {
        $this->class->memory_limit = 100;

        $this->assertFalse(ini_get('date.memory_limit'));
    }

    /**
     * Test getting an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__get
     */
    public function testGettingExistingKey(): void
    {
        $this->assertEquals(ini_get('date.timezone'), $this->class->timezone);
    }

    /**
     * Test getting a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__get
     */
    public function testGettingNonExistingKey(): void
    {
        $this->assertFalse($this->class->memory_limit);
    }

    /**
     * Test restoring an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__unset
     */
    public function testRestoringExistingKey(): void
    {
        $zone = ini_get('date.timezone');

        ini_set('date.timezone', 'Europe/Amsterdam');

        $this->class->timezone = 'America/Chicago';

        $this->assertEquals('America/Chicago', ini_get('date.timezone'));

        unset($this->class->timezone);

        $this->assertEquals($zone, ini_get('date.timezone'));
    }

    /**
     * Test restoring a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__unset
     */
    public function testRestoringNonExistingKey(): void
    {
        unset($this->class->memory_limit);

        $this->assertFalse(ini_get('date.memory_limit'));
    }

}

?>
