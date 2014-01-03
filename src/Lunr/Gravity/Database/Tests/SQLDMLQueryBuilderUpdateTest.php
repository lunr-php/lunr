<?php

/**
 * This file contains the SQLDMLQueryBuilderUpdateTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * update queries.
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderUpdateTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the SELECT part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsUpdateTest::testInitialUpdate
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsUpdateTest::testIncrementalUpdate
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::update
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
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::update
     */
    public function testUpdateReturnsSelfReference()
    {
        $return = $this->class->update('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the set method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::set
     */
    public function testSetReturnsSelfReference()
    {
        $return = $this->class->set(array('column1' => 'value1'));

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
