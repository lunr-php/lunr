<?php

/**
 * This file contains the IniMainTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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
    public function setUp()
    {
        parent::setupMain();
    }

    /**
     * Verify that section is NULL for main ini configuration handling.
     */
    public function testSectionIsNull()
    {
        $this->assertNull($this->get_reflection_property_value('section'));
    }

    /**
     * Test setting an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__set
     */
    public function testSettingExistingKey()
    {
        $limit = ini_get('memory_limit');

        $suffix = str_replace((int) $limit, '',$limit);

        $this->class->memory_limit = ((int) $limit + 100) . $suffix;

        $this->assertEquals(((int) $limit + 100) . $suffix, ini_get('memory_limit'));

        ini_restore('memory_limit');
    }

    /**
     * Test setting a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__set
     */
    public function testSettintNonExistingKey()
    {
        $this->class->memory_limiet = 100;

        $this->assertFalse(ini_get('memory_limiet'));
    }

    /**
     * Test getting an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__get
     */
    public function testGettingExistingKey()
    {
        $this->assertEquals(ini_get('memory_limit'), $this->class->memory_limit);
    }

    /**
     * Test getting a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__get
     */
    public function testGettingNonExistingKey()
    {
        $this->assertFalse($this->class->memory_limiet);
    }

    /**
     * Test restoring an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__unset
     */
    public function testRestoringExistingKey()
    {
        $limit = ini_get('memory_limit');

        $suffix = str_replace((int) $limit, '',$limit);

        $this->class->memory_limit = ((int) $limit + 100) . $suffix;

        $this->assertEquals(((int) $limit + 100) . $suffix, ini_get('memory_limit'));

        unset($this->class->memory_limit);

        $this->assertEquals($limit, ini_get('memory_limit'));
    }

    /**
     * Test restoring a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__unset
     */
    public function testRestoringNonExistingKey()
    {
        unset($this->class->memory_limiet);

        $this->assertFalse(ini_get('memory_limiet'));
    }

}

?>
