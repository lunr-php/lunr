<?php

/**
 * This file contains the DatabaseConnectionBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains the tests for the DatabaseConnection class.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseConnection
 */
class DatabaseConnectionBaseTest extends DatabaseConnectionTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the Configuration class is passed by reference.
     */
    public function testConfigurationIsPassedByReference()
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

    /**
     * Test that the connected flag is set to FALSE by default.
     */
    public function testConnectedIsFalse()
    {
        $this->assertFalse($this->get_reflection_property_value('connected'));
    }

    /**
     * Test that the readonly flag is set to TRUE by default.
     */
    public function testReadonlyIsFalseByDefault()
    {
        $this->assertFalse($this->get_reflection_property_value('readonly'));
    }

    /**
     * Test that by default we don't have a QueryEscaper instance.
     */
    public function testEscaperIsNull()
    {
        $this->assertNull($this->get_reflection_property_value('escaper'));
    }

    /**
     * Test that set_readonly sets the readonly flag when passed TRUE.
     *
     * @depends testReadonlyIsFalseByDefault
     * @covers  Lunr\Gravity\Database\DatabaseConnection::set_readonly
     */
    public function testSetReadonlySetsReadonlyWhenPassedTrue()
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
    public function testSetReadonlySetsReadwriteWhenPassedFalse()
    {
        $this->class->set_readonly(TRUE);

        $this->assertTrue($this->get_reflection_property_value('readonly'));

        $this->class->set_readonly(FALSE);

        $this->assertFalse($this->get_reflection_property_value('readonly'));
    }

}

?>
