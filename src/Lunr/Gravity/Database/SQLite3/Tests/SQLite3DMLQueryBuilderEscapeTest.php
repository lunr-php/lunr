<?php

/**
 * This file contains the SQLite3DMLQueryBuilderEscapeTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for escaping values in queries.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderEscapeTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test escaping a simple value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::value
     */
    public function testEscapingValue()
    {
        $this->connection->expects($this->once())
                         ->method('escape_string')
                         ->will($this->returnValue('value'));

        $this->assertEquals('\'value\'', $this->class->value('value'));
    }

    /**
     * Test escaping a hex value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::hexvalue
     */
    public function testEscapingHexValue()
    {
        $this->connection->expects($this->once())
                         ->method('escape_string')
                         ->will($this->returnValue('value'));

        $this->assertEquals('\'value\'', $this->class->hexvalue('value'));
    }

    /**
     * Test escaping a default like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValue()
    {
        $this->connection->expects($this->once())
                         ->method('escape_string')
                         ->will($this->returnValue('value'));

        $this->assertEquals('\'%value%\'', $this->class->likevalue('value'));
    }

    /**
     * Test escaping a forward like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueForward()
    {
        $this->connection->expects($this->once())
                         ->method('escape_string')
                         ->will($this->returnValue('value'));

        $this->assertEquals('\'value%\'', $this->class->likevalue('value', 'forward'));
    }

    /**
     * Test escaping a backward like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueBackward()
    {
        $this->connection->expects($this->once())
                         ->method('escape_string')
                         ->will($this->returnValue('value'));

        $this->assertEquals('\'%value\'', $this->class->likevalue('value', 'backward'));
    }

    /**
     * Test escaping a unsupported like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueUnsupported()
    {
        $this->connection->expects($this->once())
                         ->method('escape_string')
                         ->will($this->returnValue('value'));

        $this->assertEquals('\'%value%\'', $this->class->likevalue('value', 'unsupported'));
    }

    /**
     * Test escaping an index hint with invalid indices.
     *
     * @param mixed $indices Invalid indices value
     *
     * @dataProvider invalidIndicesProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::index_hint
     */
    public function testEscapingIndexHintWithInvalidIndices($indices)
    {
        $this->assertNull($this->class->index_hint('', '', $indices));
    }

    /**
     * Test escaping an index hint with valid keywords.
     *
     * @param String $keyword Valid index keyword
     *
     * @dataProvider validIndexKeywordProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::index_hint
     */
    public function testEscapingIndexHintWithValidKeyword($keyword)
    {
        $indices = array('index', 'index');

        $value = $this->class->index_hint($keyword, $indices);

        $this->assertEquals($keyword . ' "index", "index"', $value);
    }

    /**
     * Test escaping an index hint with an invalid keyword.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::index_hint
     */
    public function testEscapingIndexHintWithInvalidKeyword()
    {
        $indices = array('index', 'index');

        $value = $this->class->index_hint('invalid', $indices);

        $this->assertEquals('INDEXED BY "index", "index"', $value);
    }

}

?>
