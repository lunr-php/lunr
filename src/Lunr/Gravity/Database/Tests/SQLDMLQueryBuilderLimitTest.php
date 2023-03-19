<?php

/**
 * This file contains the SQLDMLQueryBuilderLimitTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * limit statements.
 *
 * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderLimitTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the limit part of a query with default offset.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::limit
     */
    public function testLimitWithDefaultOffset(): void
    {
        $this->class->limit(10);
        $value = $this->get_reflection_property_value('limit');

        $this->assertEquals('LIMIT 10', $value);
    }

    /**
     * Test specifying the limit part of a query with custom offset.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::limit
     */
    public function testLimitWithCustomOffset(): void
    {
        $this->class->limit(10, 20);
        $value = $this->get_reflection_property_value('limit');

        $this->assertEquals('LIMIT 10 OFFSET 20', $value);
    }

    /**
     * Test fluid interface of the limit method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::limit
     */
    public function testLimitReturnsSelfReference(): void
    {
        $return = $this->class->limit(10);

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
