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
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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

}

?>
