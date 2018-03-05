<?php

/**
 * This file contains the IniSectionTest class.
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
class IniSectionTest extends IniTest
{

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setupSection();
    }

    /**
     * Verify that section is NULL for main ini configuration handling.
     */
    public function testSectionIsNotNull()
    {
        $this->assertEquals('date', $this->get_reflection_property_value('section'));
    }

    /**
     * Test setting an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__set
     */
    public function testSettingExistingKey()
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
    public function testSettintNonExistingKey()
    {
        $this->class->memory_limit = 100;

        $this->assertFalse(ini_get('date.memory_limit'));
    }

    /**
     * Test getting an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__get
     */
    public function testGettingExistingKey()
    {
        $this->assertEquals(ini_get('date.timezone'), $this->class->timezone);
    }

    /**
     * Test getting a non-existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__get
     */
    public function testGettingNonExistingKey()
    {
        $this->assertFalse($this->class->memory_limit);
    }

    /**
     * Test restoring an existing php.ini option.
     *
     * @covers Lunr\Core\Ini::__unset
     */
    public function testRestoringExistingKey()
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
    public function testRestoringNonExistingKey()
    {
        unset($this->class->memory_limit);

        $this->assertFalse(ini_get('date.memory_limit'));
    }

}

?>
