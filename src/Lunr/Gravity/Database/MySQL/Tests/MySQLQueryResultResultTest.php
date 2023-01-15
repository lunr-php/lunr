<?php

/**
 * This file contains the MySQLQueryResultResultTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryResult;

/**
 * This class contains tests for the MySQLQueryResult class
 * based on a successful query with result.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
class MySQLQueryResultResultTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->mock_function('mysqli_affected_rows', fn() => 10);
        $this->mock_function('mysqli_num_rows', fn() => 10);

        $this->resultSetSetup();

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
     * Test that number_of_rows() returns a number.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::number_of_rows
     */
    public function testNumberOfRowsReturnsNumber(): void
    {
        $this->set_reflection_property_value('num_rows', 5);

        $value = $this->class->number_of_rows();
        $this->assertIsInt($value);
        $this->assertEquals(5, $value);
    }

    /**
     * Test that result_array() returns an multidimensional array when $associative is TRUE.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_array
     */
    public function testResultArrayReturnsArrayWhenAssociativeIsTrue(): void
    {
        $result = [
            [
                'col1' => 'val1',
                'col2' => 'val2',
            ],
            [
                'col1' => 'val3',
                'col2' => 'val4',
            ],
        ];

        $this->query_result->expects($this->once())
                           ->method('fetch_all')
                           ->with(MYSQLI_ASSOC)
                           ->willReturn($result);

        $value = $this->class->result_array();

        $this->assertIsArray($value);
        $this->assertEquals($result, $value);
    }

    /**
     * Test that result_array() returns an numeric array when $associative is FALSE.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_array
     */
    public function testResultArrayReturnsArrayWhenAssociativeIsFalse(): void
    {
        $result = [
            [
                'val1', 'val2',
            ],
            [
                'val3', 'val4',
            ],
        ];

        $this->query_result->expects($this->once())
                           ->method('fetch_all')
                           ->with(MYSQLI_NUM)
                           ->willReturn($result);

        $value = $this->class->result_array(FALSE);

        $this->assertIsArray($value);
        $this->assertEquals($result, $value);
    }

    /**
     * Test that result_row() returns an one-dimensional array.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_row
     */
    public function testResultRowReturnsArray(): void
    {
        $result = [ 'col1' => 'val1', 'col2' => 'val2' ];
        $this->query_result->expects($this->once())
                           ->method('fetch_assoc')
                           ->will($this->returnValue($result));

        $value = $this->class->result_row();

        $this->assertIsArray($value);
        $this->assertEquals($result, $value);
    }

    /**
     * Test that result_column() returns an one-dimensional array.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_column
     */
    public function testResultColumnReturnsArray(): void
    {
        $this->query_result->expects($this->exactly(3))
                           ->method('fetch_assoc')
                           ->willReturnOnConsecutiveCalls(
                               [ 'col1' => 'val1', 'col2' => 'val2' ],
                               [ 'col1' => 'val3', 'col2' => 'val4' ],
                               NULL
                           );

        $value = $this->class->result_column('col1');

        $this->assertIsArray($value);
        $this->assertEquals([ 'val1', 'val3' ], $value);
    }

    /**
     * Test that result_cell() returns value.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellReturnsValue(): void
    {
        $this->query_result->expects($this->once())
                           ->method('fetch_assoc')
                           ->will($this->returnValue([ 'cell' => 'value' ]));

        $this->assertEquals('value', $this->class->result_cell('cell'));
    }

    /**
     * Test that result_cell() returns NULL if the column doesn't exist.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellReturnsNullIfColumnDoesNotExist(): void
    {
        $this->query_result->expects($this->once())
                           ->method('fetch_assoc')
                           ->will($this->returnValue([ 'cell' => 'value' ]));

        $this->assertNull($this->class->result_cell('cell1'));
    }

}

?>
