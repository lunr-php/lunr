<?php

/**
 * This file contains the IniMainTest class.
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
class IniMainTest extends IniTest
{

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setupMain();
    }

    /**
     * Verify that section is NULL for main ini configuration handling.
     */
    public function testSectionIsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('section'));
    }

    /**
     * Test setting an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__set
     */
    public function testSettingExistingKey(): void
    {
        $limit = ini_get('memory_limit');

        $suffix = str_replace((int) $limit, '', $limit);

        $int_limit = (int) $limit;

        if ($int_limit === -1)
        {
            $int_limit = 1024;
            $suffix    = 'M';
        }

        $this->class->memory_limit = ($int_limit + 100) . $suffix;

        $this->assertEquals(($int_limit + 100) . $suffix, ini_get('memory_limit'));

        ini_restore('memory_limit');
    }

    /**
     * Test setting a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__set
     */
    public function testSettintNonExistingKey(): void
    {
        $this->class->memory_limiet = 100;

        $this->assertFalse(ini_get('memory_limiet'));
    }

    /**
     * Test getting an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__get
     */
    public function testGettingExistingKey(): void
    {
        $this->assertEquals(ini_get('memory_limit'), $this->class->memory_limit);
    }

    /**
     * Test getting a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__get
     */
    public function testGettingNonExistingKey(): void
    {
        $this->assertFalse($this->class->memory_limiet);
    }

    /**
     * Test restoring an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__unset
     */
    public function testRestoringExistingKey(): void
    {
        $limit = ini_get('memory_limit');

        $suffix = str_replace((int) $limit, '', $limit);

        $int_limit = (int) $limit;

        if ($int_limit === -1)
        {
            $int_limit = 1024;
            $suffix    = 'M';
        }

        $this->class->memory_limit = ($int_limit + 100) . $suffix;

        $this->assertEquals(($int_limit + 100) . $suffix, ini_get('memory_limit'));

        unset($this->class->memory_limit);

        $this->assertEquals($limit, ini_get('memory_limit'));
    }

    /**
     * Test restoring a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__unset
     */
    public function testRestoringNonExistingKey(): void
    {
        unset($this->class->memory_limiet);

        $this->assertFalse(ini_get('memory_limiet'));
    }

}

?>
