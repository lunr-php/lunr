<?php

/**
 * This file contains the MySQLDMLQueryBuilderEscapeTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for escaping values in queries.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderEscapeTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test escaping a simple value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::value
     */
    public function testEscapingValue()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'value\'', $this->builder->value('value'));
    }

    /**
     * Test escaping a value with a collation specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::value
     */
    public function testEscapingValueWithCollation()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'value\' COLLATE utf8_general_ci', $this->builder->value('value', 'utf8_general_ci'));
    }

    /**
     * Test escaping a value with charset specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::value
     */
    public function testEscapingValueWithCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('ascii \'value\'', $this->builder->value('value', '', 'ascii'));
    }

    /**
     * Test escaping a value with a collation and charset specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::value
     */
    public function testEscapingValueWithCollationAndCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $string = 'ascii \'value\' COLLATE utf8_general_ci';

        $this->assertEquals($string, $this->builder->value('value', 'utf8_general_ci', 'ascii'));
    }

    /**
     * Test escaping a hex value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::hexvalue
     */
    public function testEscapingHexValue()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('UNHEX(\'value\')', $this->builder->hexvalue('value'));
    }

    /**
     * Test escaping a hex value with a collation specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::hexvalue
     */
    public function testEscapingHexValueWithCollation()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $string = 'UNHEX(\'value\') COLLATE utf8_general_ci';

        $this->assertEquals($string, $this->builder->hexvalue('value', 'utf8_general_ci'));
    }

    /**
     * Test escaping a hex value with charset specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::hexvalue
     */
    public function testEscapingHexValueWithCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('ascii UNHEX(\'value\')', $this->builder->hexvalue('value', '', 'ascii'));
    }

    /**
     * Test escaping a hex value with a collation and charset specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::hexvalue
     */
    public function testEscapingHexValueWithCollationAndCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $string = 'ascii UNHEX(\'value\') COLLATE utf8_general_ci';

        $this->assertEquals($string, $this->builder->hexvalue('value', 'utf8_general_ci', 'ascii'));
    }

    /**
     * Test escaping a default like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValue()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'%value%\'', $this->builder->likevalue('value'));
    }

    /**
     * Test escaping a default like value with a collation specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueWithCollation()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $string = '\'%value%\' COLLATE utf8_general_ci';

        $this->assertEquals($string, $this->builder->likevalue('value', 'both', 'utf8_general_ci'));
    }

    /**
     * Test escaping a default like value with charset specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueWithCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('ascii \'%value%\'', $this->builder->likevalue('value', 'both', '', 'ascii'));
    }

    /**
     * Test escaping a default like value with a collation and charset specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueWithCollationAndCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $string = 'ascii \'%value%\' COLLATE utf8_general_ci';

        $this->assertEquals($string, $this->builder->likevalue('value', 'both', 'utf8_general_ci', 'ascii'));
    }

    /**
     * Test escaping a forward like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueForward()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'value%\'', $this->builder->likevalue('value', 'forward'));
    }

    /**
     * Test escaping a backward like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueBackward()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'%value\'', $this->builder->likevalue('value', 'backward'));
    }

    /**
     * Test escaping a unsupported like value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueUnsupported()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'%value%\'', $this->builder->likevalue('value', 'unsupported'));
    }

    /**
     * Test escaping an index hint with invalid indices.
     *
     * @param mixed $indices Invalid indices value
     *
     * @dataProvider invalidIndicesProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::index_hint
     */
    public function testEscapingIndexHintWithInvalidIndices($indices)
    {
        $this->assertNull($this->builder->index_hint('', '', $indices));
    }

    /**
     * Test escaping an index hint with valid keywords.
     *
     * @param String $keyword Valid index keyword
     *
     * @dataProvider validIndexKeywordProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::index_hint
     */
    public function testEscapingIndexHintWithValidKeyword($keyword)
    {
        $indices = array('index', 'index');

        $value = $this->builder->index_hint($keyword, $indices);

        $this->assertEquals($keyword . ' INDEX (`index`, `index`)', $value);
    }

    /**
     * Test escaping an index hint with an invalid keyword.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::index_hint
     */
    public function testEscapingIndexHintWithInvalidKeyword()
    {
        $indices = array('index', 'index');

        $value = $this->builder->index_hint('invalid', $indices);

        $this->assertEquals('USE INDEX (`index`, `index`)', $value);
    }

    /**
     * Test escaping an index hint with valid use definition.
     *
     * @param String $for Valid use definition
     *
     * @dataProvider validIndexForProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::index_hint
     */
    public function testEscapingIndexHintWithValidFor($for)
    {
        $indices = array('index', 'index');

        $value = $this->builder->index_hint('USE', $indices, $for);

        if ($for === '')
        {
            $this->assertEquals('USE INDEX (`index`, `index`)', $value);
        }
        else
        {
            $this->assertEquals('USE INDEX FOR ' . $for . ' (`index`, `index`)', $value);
        }
    }

    /**
     * Test escaping an index hint with an invalid use definition.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::index_hint
     */
    public function testEscapingIndexHintWithInvalidFor()
    {
        $indices = array('index', 'index');

        $value = $this->builder->index_hint('invalid', $indices, 'invalid');

        $this->assertEquals('USE INDEX (`index`, `index`)', $value);
    }

}

?>
