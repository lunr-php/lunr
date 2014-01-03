<?php

/**
 * This file contains the SQLDMLQueryBuilderDeleteTest class.
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

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * delete queries.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderDeleteTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the DELETE part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsDeleteTest::testInitialDelete
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsDeleteTest::testIncrementalDelete
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::delete
     */
    public function testDelete()
    {
        $this->class->delete('table');
        $value = $this->get_reflection_property_value('delete');

        $this->assertEquals('table', $value);
    }

    /**
     * Test fluid interface of the delete method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::delete
     */
    public function testDeleteReturnsSelfReference()
    {
        $return = $this->class->delete('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
