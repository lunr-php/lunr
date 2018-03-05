<?php

/**
 * This file contains the SQLDMLQueryBuilderUsingTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts methods.
 *
 * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class SQLDMLQueryBuilderUsingTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test using().
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::using
     */
    public function testUsing()
    {
        $this->set_reflection_property_value('is_unfinished_join', TRUE);

        $this->class->using('column1');

        $string = ' USING (column1)';

        $this->assertPropertyEquals('join', $string);
    }

    /**
     * Test using().
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::using
     */
    public function testUsingAddSecondColumn()
    {
        $this->set_reflection_property_value('join_type', 'using');
        $this->set_reflection_property_value('join', ' USING (column1)');

        $this->class->using('column2');

        $string = ' USING (column1, column2)';

        $this->assertPropertyEquals('join', $string);
    }

    /**
     * Test using().
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::using
     */
    public function testUsingMultipleColumn()
    {
        $this->set_reflection_property_value('is_unfinished_join', TRUE);

        $this->class->using('column1, column2');

        $string = ' USING (column1, column2)';

        $this->assertPropertyEquals('join', $string);
    }

}

?>
