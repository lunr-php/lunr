<?php

/**
 * This file contains the MySQLDMLQueryBuilderGroupByTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * group by statement.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderGroupByTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the group by part of a query with default order.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::group_by
     */
    public function testGroupByWithDefaultOrder(): void
    {
        $property = $this->builder_reflection->getProperty('group_by');
        $property->setAccessible(TRUE);

        $this->builder->group_by('group1');

        $this->assertEquals('GROUP BY group1', $property->getValue($this->builder));
    }

    /**
     * Test specifying the group by part of a query with custom order.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::group_by
     */
    public function testGroupByWithCustomOrder(): void
    {
        $property = $this->builder_reflection->getProperty('group_by');
        $property->setAccessible(TRUE);

        $this->builder->group_by('group1', FALSE);
        $this->assertEquals('GROUP BY group1 DESC', $property->getValue($this->builder));

        $this->builder->group_by('group2', TRUE);
        $this->assertEquals('GROUP BY group1 DESC, group2 ASC', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the group by method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::group_by
     */
    public function testGroupByReturnsSelfReference(): void
    {
        $return = $this->builder->group_by('group1');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

}

?>
