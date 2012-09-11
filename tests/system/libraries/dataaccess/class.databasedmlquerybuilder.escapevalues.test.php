<?php

/**
 * This file contains the DatabaseDMLQueryBuilderEscapeValuesTest class.
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
 * This class contains the tests for escaping column names.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderEscapeValuesTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test collate() with a value only.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::collate
     */
    public function testCollateWithValueOnly()
    {
        $method = $this->builder_reflection->getMethod('collate');
        $method->setAccessible(TRUE);

        $this->assertEquals('value', $method->invokeArgs($this->builder, array('value', '')));
    }

    /**
     * Test collate() with value and collation specified.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::collate
     */
    public function testCollateWithCollation()
    {
        $method = $this->builder_reflection->getMethod('collate');
        $method->setAccessible(TRUE);

        $this->assertEquals('value COLLATE utf8_general_ci', $method->invokeArgs($this->builder, array('value', 'utf8_general_ci')));
    }

    /**
     * Test column() with only a name value.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testCollateWithValueOnly
     * @depends      Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::column
     */
    public function testColumnWithoutCollation($col, $escaped)
    {
        $value = $this->builder->column($col);

        $this->assertEquals($escaped, $value);
    }

    /**
     * Test column() with name and collation value.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends testCollateWithCollation
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::column
     */
    public function testColumnWithCollation($col, $escaped)
    {
        $value = $this->builder->column($col, 'utf8_general_ci');

        $this->assertEquals($escaped . ' COLLATE utf8_general_ci', $value);
    }

}

?>
