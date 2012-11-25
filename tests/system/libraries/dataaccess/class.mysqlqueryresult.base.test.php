<?php

/**
 * This file contains the MySQLQueryResultBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains basic tests for the MySQLQueryResult class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLQueryResult
 */
class MySQLQueryResultBaseTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->successfulSetup();
    }

    /**
     * Test that the mysqli class is passed by reference.
     */
    public function testMysqliIsPassedByReference()
    {
        $property = $this->result_reflection->getProperty('mysqli');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->result);

        $this->assertInstanceOf('\mysqli', $value);
        $this->assertSame($this->mysqli, $value);
    }

    /**
     * Test that affected_rows() returns a number.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLQueryResult::affected_rows
     */
    public function testAffectedRowsReturnsNumber()
    {
        $mysqli = new MockMySQLiSuccessfulConnection();

        $class = $this->result_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, $mysqli);

        $value = $this->result->affected_rows();
        $this->assertInternalType('int', $value);
        $this->assertEquals(10, $value);
    }

}

?>
