<?php

/**
 * This file contains the SQLite3QueryEscaperEscapeTest class.
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper;

/**
 * This class contains the tests for escaping values in queries.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper
 */
class SQLite3QueryEscaperEscapeTest extends SQLite3QueryEscaperTest
{

    /**
     * Test escaping a simple value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper::value
     */
    public function testEscapingValue(): void
    {
        $this->escaper->expects($this->once())
                      ->method('escape_string')
                      ->will($this->returnValue('value'));

        $this->assertEquals('\'value\'', $this->class->value('value'));
    }

    /**
     * Test escaping a hex value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper::hexvalue
     */
    public function testEscapingHexValue(): void
    {
        $this->escaper->expects($this->once())
                      ->method('escape_string')
                      ->will($this->returnValue('value'));

        $this->assertEquals('\'value\'', $this->class->hexvalue('value'));
    }

    /**
     * Test escaping a default like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper::likevalue
     */
    public function testEscapingLikeValue(): void
    {
        $this->escaper->expects($this->once())
                      ->method('escape_string')
                      ->will($this->returnValue('value'));

        $this->assertEquals('\'%value%\'', $this->class->likevalue('value'));
    }

    /**
     * Test escaping a forward like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper::likevalue
     */
    public function testEscapingLikeValueForward(): void
    {
        $this->escaper->expects($this->once())
                      ->method('escape_string')
                      ->will($this->returnValue('value'));

        $this->assertEquals('\'value%\'', $this->class->likevalue('value', 'forward'));
    }

    /**
     * Test escaping a backward like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper::likevalue
     */
    public function testEscapingLikeValueBackward(): void
    {
        $this->escaper->expects($this->once())
                      ->method('escape_string')
                      ->will($this->returnValue('value'));

        $this->assertEquals('\'%value\'', $this->class->likevalue('value', 'backward'));
    }

    /**
     * Test escaping a unsupported like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper::likevalue
     */
    public function testEscapingLikeValueUnsupported(): void
    {
        $this->escaper->expects($this->once())
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
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper::index_hint
     */
    public function testEscapingIndexHintWithInvalidIndices($indices): void
    {
        $this->assertNull($this->class->index_hint('', '', $indices));
    }

    /**
     * Test escaping an index hint with valid keywords.
     *
     * @param string $keyword Valid index keyword
     *
     * @dataProvider validIndexKeywordProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper::index_hint
     */
    public function testEscapingIndexHintWithValidKeyword($keyword): void
    {
        $indices = [ 'index', 'index' ];

        $value = $this->class->index_hint($keyword, $indices);

        $this->assertEquals($keyword . ' "index", "index"', $value);
    }

    /**
     * Test escaping an index hint with an invalid keyword.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testEscapeLocationReference
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper::index_hint
     */
    public function testEscapingIndexHintWithInvalidKeyword(): void
    {
        $indices = [ 'index', 'index' ];

        $value = $this->class->index_hint('invalid', $indices);

        $this->assertEquals('INDEXED BY "index", "index"', $value);
    }

}

?>
