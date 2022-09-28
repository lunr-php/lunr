<?php

/**
 * This file contains the DatabaseQueryEscaperEscapeTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseQueryEscaper;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseQueryEscaper class.
 *
 * @covers Lunr\Gravity\Database\DatabaseQueryEscaper
 */
class DatabaseQueryEscaperEscapeTest extends DatabaseQueryEscaperTest
{

    /**
     * Test escaping column names.
     *
     * @param string $col     Raw column name
     * @param string $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::escape_location_reference
     */
    public function testEscapeLocationReference($col, $escaped): void
    {
        $method = $this->get_accessible_reflection_method('escape_location_reference');
        $this->assertEquals($escaped, $method->invokeArgs($this->class, [ $col ]));
    }

    /**
     * Test collate() with a value only.
     *
     * @covers Lunr\Gravity\Database\DatabaseQueryEscaper::collate
     */
    public function testCollateWithValueOnly(): void
    {
        $method = $this->get_accessible_reflection_method('collate');
        $this->assertEquals('value', $method->invokeArgs($this->class, [ 'value', '' ]));
    }

    /**
     * Test collate() with value and collation specified.
     *
     * @covers Lunr\Gravity\Database\DatabaseQueryEscaper::collate
     */
    public function testCollateWithCollation(): void
    {
        $method = $this->get_accessible_reflection_method('collate');

        $string = 'value COLLATE utf8_general_ci';

        $this->assertEquals($string, $method->invokeArgs($this->class, [ 'value', 'utf8_general_ci' ]));
    }

    /**
     * Test column() with only a name value.
     *
     * @param string $col     Raw column name
     * @param string $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testCollateWithValueOnly
     * @depends      testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::column
     */
    public function testColumnWithoutCollation($col, $escaped): void
    {
        $this->assertEquals($escaped, $this->class->column($col));
    }

    /**
     * Test column() with name and collation value.
     *
     * @param string $col     Raw column name
     * @param string $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testCollateWithCollation
     * @depends      testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::column
     */
    public function testColumnWithCollation($col, $escaped): void
    {
        $value = $this->class->column($col, 'utf8_general_ci');

        $this->assertEquals($escaped . ' COLLATE utf8_general_ci', $value);
    }

    /**
     * Test result_column() without alias.
     *
     * @param string $col     Raw column name
     * @param string $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::result_column
     */
    public function testResultColumnWithoutAlias($col, $escaped): void
    {
        $this->assertEquals($escaped, $this->class->result_column($col));
    }

    /**
     * Test result_column() with alias.
     *
     * @param string $col     Raw column name
     * @param string $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::result_column
     */
    public function testResultColumnWithAlias($col, $escaped): void
    {
        $alias = 'alias';
        $value = $this->class->result_column($col, $alias);

        if ($col === '*')
        {
            $this->assertEquals($escaped, $value);
        }
        else
        {
            $this->assertEquals($escaped . ' AS `alias`', $value);
        }
    }

    /**
     * Test hex_result_column() without alias.
     *
     * @param string $col     Raw column name
     * @param string $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::hex_result_column
     */
    public function testHexResultColumnWithoutAlias($col, $escaped): void
    {
        $value = $this->class->hex_result_column($col);

        $this->assertEquals('HEX(' . $escaped . ') AS `' . $col . '`', $value);
    }

    /**
     * Test hex_result_column() with alias.
     *
     * @param string $col     Raw column name
     * @param string $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::hex_result_column
     */
    public function testHexResultColumnWithAlias($col, $escaped): void
    {
        $alias = 'alias';
        $value = $this->class->hex_result_column($col, $alias);

        $this->assertEquals('HEX(' . $escaped . ') AS `' . $alias . '`', $value);
    }

    /**
     * Test table() without alias.
     *
     * @param string $table   Raw table name
     * @param string $escaped Expected escaped table name
     *
     * @dataProvider tableNameProvider
     * @depends      testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::table
     */
    public function testTableWithoutAlias($table, $escaped): void
    {
        $value = $this->class->table($table);

        $this->assertEquals($escaped, $value);
    }

    /**
     * Test table() with alias.
     *
     * @param string $table   Raw table name
     * @param string $escaped Expected escaped table name
     *
     * @dataProvider tableNameProvider
     * @depends      testEscapeLocationReference
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::table
     */
    public function testTableWithAlias($table, $escaped): void
    {
        $alias = 'alias';
        $value = $this->class->table($table, $alias);

        $this->assertEquals($escaped . ' AS `alias`', $value);
    }

    /**
     * Test escaping an integer.
     *
     * @param mixed $value    The input value to be escaped
     * @param int   $expected The expected escaped integer
     *
     * @dataProvider expectedIntegerProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::intvalue
     */
    public function testEscapeIntValue($value, $expected): void
    {
        $this->assertEquals($expected, $this->class->intvalue($value));
    }

    /**
     * Test escaping an object as integer.
     *
     * @covers Lunr\Gravity\Database\DatabaseQueryEscaper::intvalue
     */
    public function testEscapeObjectAsIntValue(): void
    {
        if (PHP_VERSION_ID >= 80000)
        {
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            $this->expectException('\PHPUnit\Framework\Error\Notice');
        }

        $message = 'Object of class ' . get_class($this->class) . ' could not be converted to int';
        $this->expectExceptionMessage($message);

        $this->assertEquals(0, $this->class->intvalue($this->class));
    }

    /**
     * Test escaping illegal value as integer.
     *
     * @param mixed $value   The input value to be escaped
     * @param int   $illegal The illegal escaped integer
     *
     * @dataProvider illegalIntegerProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::intvalue
     */
    public function testEscapeIllegalAsIntValue($value, $illegal): void
    {
        $this->assertEquals($illegal, $this->class->intvalue($value));
    }

    /**
     * Test escaping a float.
     *
     * @param mixed $value    The input value to be escaped
     * @param int   $expected The expected escaped float
     *
     * @dataProvider expectedFloatProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::floatvalue
     */
    public function testEscapeFloatValue($value, $expected): void
    {
        $this->assertEquals($expected, $this->class->floatvalue($value));
    }

    /**
     * Test escaping an object as float.
     *
     * @covers Lunr\Gravity\Database\DatabaseQueryEscaper::floatvalue
     */
    public function testEscapeObjectAsFloatValue(): void
    {
        if (PHP_VERSION_ID >= 80000)
        {
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            $this->expectException('\PHPUnit\Framework\Error\Notice');
        }

        $message = 'Object of class ' . get_class($this->class) . ' could not be converted to float';
        $this->expectExceptionMessage($message);

        $this->assertEquals(0, $this->class->floatvalue($this->class));
    }

    /**
     * Test escaping illegal value as float.
     *
     * @param mixed $value   The input value to be escaped
     * @param int   $illegal The illegal escaped float
     *
     * @dataProvider illegalFloatProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::floatvalue
     */
    public function testEscapeIllegalAsFloatValue($value, $illegal): void
    {
        $this->assertEquals($illegal, $this->class->floatvalue($value));
    }

    /**
     * Test prepending and apending parentheses to a value.
     *
     * @covers Lunr\Gravity\Database\DatabaseQueryEscaper::query_value
     */
    public function testEscapeQueryValue(): void
    {
        $this->assertEquals('(value)', $this->class->query_value('value'));
    }

    /**
     * Test prepending and apending parentheses to a list of values, extracted from an array.
     *
     * @covers Lunr\Gravity\Database\DatabaseQueryEscaper::list_value
     */
    public function testEscapeListValueSimpleArray(): void
    {
        $values = [ 'value1', 'value2' ];
        $this->assertEquals('(value1,value2)', $this->class->list_value($values));
    }

    /**
     * Test prepending and apending parentheses to a list of values.
     *
     * @covers Lunr\Gravity\Database\DatabaseQueryEscaper::list_value
     */
    public function testEscapeListValueSimpleArrayOne(): void
    {
        $values = [ 'value1' ];
        $this->assertEquals('(value1)', $this->class->list_value($values));
    }

    /**
     * Test list_value() with invalid input.
     *
     * @param mixed $value Invalid input
     *
     * @dataProvider invalidListValueInputProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::list_value
     */
    public function testEscapeListValueWithInvalidInput($value): void
    {
        $this->assertEquals('', $this->class->list_value($value));
    }

}

?>
