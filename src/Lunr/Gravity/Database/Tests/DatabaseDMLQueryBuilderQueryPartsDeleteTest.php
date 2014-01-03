<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsDeleteTest class.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods that are used when building DELETE statements
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsDeleteTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the delete part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_delete
     */
    public function testInitialDelete()
    {
        $method = $this->get_accessible_reflection_method('sql_delete');

        $method->invokeArgs($this->class, [ 'table' ]);

        $string = 'table';

        $this->assertPropertyEquals('delete', $string);
    }

    /**
     * Test specifying the select part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_delete
     */
    public function testIncrementalDelete()
    {
        $method = $this->get_accessible_reflection_method('sql_delete');

        $method->invokeArgs($this->class, [ 'table' ]);
        $method->invokeArgs($this->class, [ 'table.*' ]);

        $string = 'table, table.*';

        $this->assertPropertyEquals('delete', $string);
    }

}

?>
