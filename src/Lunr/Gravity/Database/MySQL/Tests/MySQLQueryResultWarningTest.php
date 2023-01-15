<?php

/**
 * This file contains the MySQLQueryResultWarningTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Brian Stoop <b.stoop@m2mobi.com>
 * @copyright  2021, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class contains tests for the MySQLQueryResult class
 * based on a successful query with warnings.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
class MySQLQueryResultWarningTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->mock_function('mysqli_affected_rows', fn() => 10);
        $this->mock_function('mysqli_num_rows', fn() => 10);

        $this->warningSetup();

        $this->unmock_function('mysqli_affected_rows');
        $this->unmock_function('mysqli_num_rows');
    }

    /**
     * Test that the success flag is TRUE.
     *
     * @requires extension mysqli
     */
    public function testSuccessIsTrue(): void
    {
        $this->assertTrue($this->get_reflection_property_value('success'));
    }

    /**
     * Test that the freed flasg is FALSE.
     *
     * @requires extension mysqli
     */
    public function testFreedIsFalse(): void
    {
        $this->assertFalse($this->get_reflection_property_value('freed'));
    }

    /**
     * Test that the has_failed() method returns FALSE.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::has_failed
     */
    public function testHasFailedReturnsFalse(): void
    {
        $this->assertFalse($this->class->has_failed());
    }

    /**
     * Test that the warnings value not is NULL
     *
     * @requires extension mysqli
     */
    public function testWarningsIsNotNull(): void
    {
        $this->assertNotNull($this->get_reflection_property_value('warnings'));
    }

    /**
     * Test that the warnings value is an array.
     *
     * @requires extension mysqli
     */
    public function testWarningsIsArrayWithLengthOfTwo(): void
    {
        $this->get_accessible_reflection_property('warnings');
        $value = $this->get_reflection_property_value('warnings');

        $this->assertIsArray($value);
        $this->assertEquals(2, count($value));
    }

    /**
     * Test that the message value of the warnings array is an string and not empty.
     *
     * @requires extension mysqli
     */
    public function testWarningsMessageIsStringAndNotEmpty(): void
    {
        $value = $this->get_reflection_property_value('warnings')[0];

        $this->assertIsString($value['message']);
        $this->assertNotEmpty($value['message']);
    }

    /**
     * Test that the sqlstate value of the warnings array is an string and not empty.
     *
     * @requires extension mysqli
     */
    public function testWarningsSqlstateIsStringAndNotEmpty(): void
    {
        $value = $this->get_reflection_property_value('warnings')[0];

        $this->assertIsString($value['sqlstate']);
        $this->assertNotEmpty($value['sqlstate']);
    }

    /**
     * Test that the errno value of the warnings array is an integer and not empty
     *
     * @requires extension mysqli
     */
    public function testWarningsErrnoIsIntegerAndNotEmpty(): void
    {
        $value = $this->get_reflection_property_value('warnings')[0];

        $this->assertIsInt($value['errno']);
        $this->assertNotEmpty($value['errno']);
    }

    /**
     * Test that the warning() returns the warnings property
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::warnings
     */
    public function testWarningsReturnsWarnings(): void
    {
        $value = $this->class->warnings();

        $this->assertPropertyEquals('warnings', $value);
    }

}

?>
