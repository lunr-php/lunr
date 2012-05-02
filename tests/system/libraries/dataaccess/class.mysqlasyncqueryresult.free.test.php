<?php

/**
 * This file contains the MySQLAsyncQueryResultFreeTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;
use MySQLi_Result;

/**
 * This class contains tests for the freeing of fetched data in the MySQLAsyncQueryResult class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLAsyncQueryResult
 */
class MySQLAsyncQueryResultFreeTest extends MySQLAsyncQueryResultTest
{

    /**
     * Test that result_array() will free the fetched data if it is not boolean.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::result_array
     */
    public function testResultArrayFreesDataIfNotBoolean()
    {
        $result = $this->getMockBuilder('MySQLi_Result')
                       ->disableOriginalConstructor()
                       ->getMock();

        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue($result));

        $result->expects($this->once())
               ->method('free');

        $this->result->result_array();
    }

    /**
     * Test that result_array() will not free the fetched data if it is boolean.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::result_array
     */
    public function testResultArrayDoesNotFreeDataIfBoolean()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(TRUE));

        $this->mysqli->expects($this->never())
                     ->method('free');

        $this->result->result_array();
    }

    /**
     * Test that result_row() will free the fetched data if it is not boolean.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::result_row
     */
    public function testResultRowFreesDataIfNotBoolean()
    {
        $result = $this->getMockBuilder('MySQLi_Result')
                       ->disableOriginalConstructor()
                       ->getMock();

        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue($result));

        $result->expects($this->once())
               ->method('free');

        $this->result->result_row();
    }

    /**
     * Test that result_row() will not free the fetched data if it is boolean.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::result_row
     */
    public function testResultRowDoesNotFreeDataIfBoolean()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(TRUE));

        $this->mysqli->expects($this->never())
                     ->method('free');

        $this->result->result_row();
    }

    /**
     * Test that result_column() will free the fetched data if it is not boolean.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::result_column
     */
    public function testResultColumnFreesDataIfNotBoolean()
    {
        $result = $this->getMockBuilder('MySQLi_Result')
                       ->disableOriginalConstructor()
                       ->getMock();

        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue($result));

        $result->expects($this->once())
               ->method('free');

        $this->result->result_column('col');
    }

    /**
     * Test that result_column() will not free the fetched data if it is boolean.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::result_column
     */
    public function testResultColumnDoesNotFreeDataIfBoolean()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(TRUE));

        $this->mysqli->expects($this->never())
                     ->method('free');

        $this->result->result_column('col');
    }

    /**
     * Test that result_cell() will free the fetched data if it is not boolean.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::result_cell
     */
    public function testResultCellFreesDataIfNotBoolean()
    {
        $result = $this->getMockBuilder('MySQLi_Result')
                       ->disableOriginalConstructor()
                       ->getMock();

        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue($result));

        $result->expects($this->once())
               ->method('free');

        $this->result->result_cell('cell');
    }

    /**
     * Test that result_cell() will not free the fetched data if it is boolean.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::result_cell
     */
    public function testResultCellDoesNotFreeDataIfBoolean()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(TRUE));

        $this->mysqli->expects($this->never())
                     ->method('free');

        $this->result->result_cell('cell');
    }

}

?>
