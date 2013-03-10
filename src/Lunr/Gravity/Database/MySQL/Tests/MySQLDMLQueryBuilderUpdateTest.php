<?php

/**
 * This file contains the MySQLDMLQueryBuilderUpdateTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * update queries.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderUpdateTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the SELECT part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsUpdateTest::testInitialUpdate
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsUpdateTest::testIncrementalUpdate
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::update
     */
    public function testUpdate()
    {
        $property = $this->builder_reflection->getProperty('update');
        $property->setAccessible(TRUE);

        $this->builder->update('table');

        $this->assertEquals('table', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the update method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::update
     */
    public function testUpdateReturnsSelfReference()
    {
        $return = $this->builder->update('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test that standard update modes are handled correctly.
     *
     * @param String $mode valid update modes.
     *
     * @dataProvider updateModesStandardProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::update_mode
     */
    public function testUpdateModeSetsStandardCorrectly($mode)
    {
        $property = $this->builder_reflection->getProperty('update_mode');
        $property->setAccessible(TRUE);

        $this->builder->update_mode($mode);

        $this->assertContains($mode, $property->getValue($this->builder));
    }

    /**
     * Test that unknown select modes are ignored.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testUpdateModeEmptyByDefault
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::update_mode
     */
    public function testUpdateModeIgnoresUnknownValues()
    {
        $property = $this->builder_reflection->getProperty('update_mode');
        $property->setAccessible(TRUE);

        $this->builder->update_mode('UNSUPPORTED');

        $value = $property->getValue($this->builder);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

}

?>
