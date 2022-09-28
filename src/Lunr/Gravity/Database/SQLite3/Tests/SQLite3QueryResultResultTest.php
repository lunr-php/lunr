<?php

/**
 * Contains SQLite3QueryResultResultTest class.
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Ruben de Groot <r.degroot@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

/**
 * This class contains the tests for testing a successful connection with a result.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult
 */
class SQLite3QueryResultResultTest extends SQLite3QueryResultTest
{

    /**
     * Override the default setUp with a setup with a result.
     */
    public function setUp(): void
    {
        $this->setUpWithResult();
    }

    /**
     * Test that the success flag is TRUE.
     */
    public function testSuccessIsTrue(): void
    {
        $this->get_accessible_reflection_property('success');
        $this->assertTrue($this->get_reflection_property_value('success'));
    }

    /**
     * Test that the freed flag is FALSE.
     */
    public function testFreedIsFalse(): void
    {
        $this->get_accessible_reflection_property('freed');
        $this->assertFalse($this->get_reflection_property_value('freed'));
    }

    /**
     * Test that the has_failed() method returns FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::has_failed
     */
    public function testHasFailedReturnsFalse(): void
    {
        $this->assertFalse($this->class->has_failed());
    }

    /**
     * Test that affected_rows() returns a number.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::affected_rows
     */
    public function testAffectedRowsReturnsNumber(): void
    {
        $this->set_reflection_property_value('affected_rows', 8);
        $this->assertSame(8, $this->class->affected_rows());
    }

    /**
     * Test that number_of_rows() returns a number.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::number_of_rows
     */
    public function testNumberOfRowsReturnsNumber(): void
    {
        $row = [ 'col1' => 'val1', 'col2' => 'val2' ];

        $this->sqlite3_result->method('fetchArray')
                             ->will($this->onConsecutiveCalls($row, $row, $row, FALSE));

        $value = $this->class->number_of_rows();

        $this->assertIsInt($value);
        $this->assertEquals(3, $value);
    }

    /**
     * Test that result_row() returns an one-dimensional array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_row
     */
    public function testResultRowReturnsArray(): void
    {
        $result = [ 'col1' => 'val1', 'col2' => 'val2' ];

        $this->sqlite3_result->expects($this->once())
                             ->method('fetchArray')
                             ->will($this->returnValue($result));

        $value = $this->class->result_row();

        $this->assertIsArray($value);
        $this->assertEquals($result, $value);
    }

    /**
     * Test that result_array() returns an multidimensional array when $associative is TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_array
     */
    public function testResultArrayReturnsArrayWhenAssociativeIsTrue(): void
    {
        $result = [ 0 => [ 'col1' => 'val1', 'col2' => 'val2' ], 1 => [ 'col1' => 'val3', 'col2' => 'val4' ] ];

        $this->sqlite3_result->expects($this->exactly(3))
                             ->method('fetchArray')
                             ->with(SQLITE3_ASSOC)
                             ->willReturnOnConsecutiveCalls($result[0], $result[1], FALSE);

        $value = $this->class->result_array();

        $this->assertIsArray($value);
        $this->assertEquals($result, $value);
    }

    /**
     * Test that result_array() returns an numeric array when $associative is FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_array
     */
    public function testResultArrayReturnsArrayWhenAssociativeIsFalse(): void
    {
        $result = [ 0 => [ 'col1' => 'val1', 'col2' => 'val2' ], 1 => [ 'col1' => 'val3', 'col2' => 'val4' ] ];

        $this->sqlite3_result->expects($this->exactly(3))
                             ->method('fetchArray')
                             ->with(SQLITE3_NUM)
                             ->willReturnOnConsecutiveCalls($result[0], $result[1], FALSE);

        $value = $this->class->result_array(FALSE);

        $this->assertIsArray($value);
        $this->assertEquals($result, $value);
    }

    /**
     * Test that result_column() returns an one-dimensional array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_column
     */
    public function testResultColumnReturnsArray(): void
    {
        $result = [ 'val1', 'val3' ];

        $this->sqlite3_result->expects($this->exactly(3))
                             ->method('fetchArray')
                             ->willReturnOnConsecutiveCalls(
                                 [ 'col1' => 'val1', 'col2' => 'val2' ],
                                 [ 'col1' => 'val3', 'col2' => 'val4' ],
                                 FALSE
                             );

        $value = $this->class->result_column('col1');

        $this->assertIsArray($value);
        $this->assertEquals($result, $value);
    }

    /**
     * Test that result_cell() returns value.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_cell
     */
    public function testResultCellReturnsValue(): void
    {
        $this->sqlite3_result->expects($this->once())
                             ->method('fetchArray')
                             ->will($this->returnValue([ 'cell' => 'value' ]));

        $this->assertEquals('value', $this->class->result_cell('cell'));
    }

    /**
     * Test that result_cell() returns NULL if the column does not exist.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_cell
     */
    public function testResultCellReturnsNullIfColumnDoesNotExist(): void
    {
        $this->sqlite3_result->expects($this->once())
                             ->method('fetchArray')
                             ->will($this->returnValue([ 'cell' => 'value' ]));

        $this->assertNull($this->class->result_cell('cell1'));
    }

}

?>
