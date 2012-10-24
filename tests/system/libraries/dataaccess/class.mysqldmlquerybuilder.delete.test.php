<?php

/**
 * This file contains the MySQLDMLQueryBuilderDeleteTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains the tests for the query parts necessary to build
 * delete queries.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderDeleteTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the DELETE part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderQueryPartsDeleteTest::testInitialDelete
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderQueryPartsDeleteTest::testIncrementalDelete
     * @covers  Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder::delete
     */
    public function testDelete()
    {
        $property = $this->builder_reflection->getProperty('delete');
        $property->setAccessible(TRUE);

        $this->builder->delete('table');

        $this->assertEquals('table', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the delete method.
     *
     * @covers  Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder::delete
     */
    public function testDeleteReturnsSelfReference()
    {
        $return = $this->builder->delete('table');

        $this->assertInstanceOf('Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test that standard delete modes are handled correctly.
     *
     * @param String $mode valid delete mode.
     *
     * @dataProvider deleteModesStandardProvider
     * @covers       Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeSetsStandardCorrectly($mode)
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $this->builder->delete_mode($mode);

        $this->assertContains($mode, $property->getValue($this->builder));
    }

    /**
     * Test that unknown delete modes are ignored.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeSetsIgnoresUnknownValues()
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $this->builder->delete_mode('UNSUPPORTED');

        $value = $property->getValue($this->builder);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test fluid interface of the delete_mode method.
     *
     * @covers  Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeReturnsSelfReference()
    {
        $return = $this->builder->delete_mode('IGNORE');

        $this->assertInstanceOf('Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test delete modes get uppercased properly
     *
     * @dataProvider expectedDeleteModesProvider
     * @covers  Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeCase($value, $expected)
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $this->builder->delete_mode($value);

        $this->assertContains($expected, $property->getValue($this->builder));
    }
}

?>
