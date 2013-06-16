<?php

/**
 * This file contains the SQLite3DMLQueryBuilderUpdateTest class.
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
 * This class contains the tests for the query parts necessary to build
 * update queries.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderUpdateTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test specifying the SELECT part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsUpdateTest::testInitialUpdate
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsUpdateTest::testIncrementalUpdate
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::update
     */
    public function testUpdate()
    {
        $this->class->update('table');
        $value = $this->get_reflection_property_value('update');

        $this->assertEquals('table', $value);
    }

    /**
     * Test fluid interface of the update method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::update
     */
    public function testUpdateReturnsSelfReference()
    {
        $return = $this->class->update('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test that standard update modes are handled correctly.
     *
     * @param String $mode valid update modes.
     *
     * @dataProvider modesProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::update_mode
     */
    public function testUpdateModeSetsStandardCorrectly($mode)
    {
        $this->class->update_mode($mode);
        $value = $this->get_reflection_property_value('update_mode');

        $mode = $mode;
        $this->assertContains($mode, $value);
    }

    /**
     * Test that unknown select modes are ignored.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testUpdateModeEmptyByDefault
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::update_mode
     */
    public function testUpdateModeIgnoresUnknownValues()
    {
        $this->class->update_mode('UNSUPPORTED');
        $value = $this->get_reflection_property_value('update_mode');

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test fluid interface of the set method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::set
     */
    public function testSetReturnsSelfReference()
    {
        $return = $this->class->set(array('column1' => 'value1'));

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
