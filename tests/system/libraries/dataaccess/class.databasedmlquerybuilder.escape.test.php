<?php

/**
 * This file contains the DatabaseDMLQueryBuilderEscapeTest class.
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

/**
 * This class contains the tests for escaping and preparing query fields.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderEscapeTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test escaping column names.
     *
     * @dataProvider columnNameProvider
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_column_name
     */
    public function testEscapeColumnName($col, $escaped)
    {
        $method = $this->builder_reflection->getMethod('escape_column_name');
        $method->setAccessible(TRUE);

        $this->assertEquals($escaped, $method->invokeArgs($this->builder, array($col)));
    }

    /**
     * Test escaping an alias definition, without an alias specified.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasOneColumnNoAlias()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col";
        $expected = "`col`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input)));
    }

    /**
     * Test escaping alias definitions, without an alias specified.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasManyColumnsNoAlias()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col1, col2, col3";
        $expected = "`col1`, `col2`, `col3`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input)));
    }

    /**
     * Test escaping an alias definition for a hex value, without an alias specified.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasOneColumnNoAliasHex()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col";
        $expected = "HEX(`col`) AS `col`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input, TRUE)));
    }

    /**
     * Test escaping alias definitions for hex values, without an alias specified.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasManyColumnsNoAliasHex()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col1, col2, col3";
        $expected = "HEX(`col1`) AS `col1`, HEX(`col2`) AS `col2`, HEX(`col3`) AS `col3`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input, TRUE)));
    }

    /**
     * Test escaping an alias definition, using upper case AS for the alias.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasOneColumnUpperCaseAs()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col AS alias";
        $expected = "`col` AS `alias`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input)));
    }

    /**
     * Test escaping an alias definition for a hex value, using upper case AS for the alias.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasOneColumnUpperCaseAsHex()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col AS alias";
        $expected = "HEX(`col`) AS `alias`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input, TRUE)));
    }

    /**
     * Test escaping alias definitions, using upper case AS for the alias.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasManyColumnsUpperCaseAs()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col1 AS alias1, col2 AS alias2, col3 AS alias3";
        $expected = "`col1` AS `alias1`, `col2` AS `alias2`, `col3` AS `alias3`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input)));
    }

    /**
     * Test escaping alias definitions for hex values, using upper case AS for the alias.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasManyColumnsUpperCaseAsHex()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col1 AS alias1, col2 AS alias2, col3 AS alias3";
        $expected = "HEX(`col1`) AS `alias1`, HEX(`col2`) AS `alias2`, HEX(`col3`) AS `alias3`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input, TRUE)));
    }

    /**
     * Test escaping an alias definition, using lower case AS for the alias.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasOneColumnLowerCaseAs()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col as alias";
        $expected = "`col` AS `alias`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input)));
    }

    /**
     * Test escaping an alias definition for a hex value, using lower case AS for the alias.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasOneColumnLowerCaseAsHex()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col as alias";
        $expected = "HEX(`col`) AS `alias`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input, TRUE)));
    }

    /**
     * Test escaping alias definitions, using lower case AS for the alias.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasManyColumnsLowerCaseAs()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col1 as alias1, col2 as alias2, col3 as alias3";
        $expected = "`col1` AS `alias1`, `col2` AS `alias2`, `col3` AS `alias3`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input)));
    }

    /**
     * Test escaping alias definitions for hex values, using lower case AS for the alias.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasManyColumnsLowerCaseAsHex()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "col1 as alias1, col2 as alias2, col3 as alias3";
        $expected = "HEX(`col1`) AS `alias1`, HEX(`col2`) AS `alias2`, HEX(`col3`) AS `alias3`";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input, TRUE)));
    }

    /**
     * Test escpaping the asterisk.
     *
     * @depends testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasAsterisk()
    {
        $method = $this->builder_reflection->getMethod('escape_alias');
        $method->setAccessible(TRUE);

        $input = "*";
        $expected = "*";

        $this->assertEquals($expected, $method->invokeArgs($this->builder, array($input)));
    }

}

?>
