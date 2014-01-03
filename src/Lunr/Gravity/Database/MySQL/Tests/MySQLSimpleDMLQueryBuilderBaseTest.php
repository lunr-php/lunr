<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;
use ReflectionClass;

/**
 * This class contains basic tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
 */
class MySQLSimpleDMLQueryBuilderBaseTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test the QueryEscaper class is passed correctly.
     */
    public function testEscaperIsPassedCorrectly()
    {
        $instance = 'Lunr\Gravity\Database\MySQL\MySQLQueryEscaper';
        $this->assertInstanceOf($instance, $this->get_reflection_property_value('escaper'));
    }

    /**
     * Test escape_alias() with aliased references.
     *
     * @param String  $input    Location reference
     * @param Boolean $type     Whether to escape a Table or a Result column
     * @param String  $name     Reference name
     * @param String  $alias    Alias
     * @param String  $expected Expected escaped string
     *
     * @dataProvider locationReferenceAliasProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasWithAlias($input, $type, $name, $alias, $expected)
    {
        $method = $type ? 'table' : 'result_column';

        $this->escaper->expects($this->once())
                      ->method($method)
                      ->with($this->equalTo($name), $this->equalTo($alias))
                      ->will($this->returnValue($expected));

        $method = $this->get_accessible_reflection_method('escape_alias');

        $result = $method->invokeArgs($this->class, [$input, $type]);

        $this->assertEquals($result, $expected);
    }

    /**
     * Test escape_alias() with plain references.
     *
     * @param String  $input    Location reference
     * @param Boolean $type     Whether to escape a Table or a Result column
     * @param String  $expected Expected escaped string
     *
     * @dataProvider locationReferenceProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasPlain($input, $type, $expected)
    {
        $method = $type ? 'table' : 'result_column';

        $this->escaper->expects($this->once())
                      ->method($method)
                      ->with($this->equalTo($input))
                      ->will($this->returnValue($expected));

        $method = $this->get_accessible_reflection_method('escape_alias');

        $result = $method->invokeArgs($this->class, [$input, $type]);

        $this->assertEquals($result, $expected);
    }

}

?>
