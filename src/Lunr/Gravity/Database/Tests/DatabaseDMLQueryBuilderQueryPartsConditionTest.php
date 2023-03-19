<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsConditionTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts methods.
 *
 * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsConditionTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying a logical connector for the query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_connector
     */
    public function testConnector(): void
    {
        $method = $this->get_accessible_reflection_method('sql_connector');

        $method->invokeArgs($this->class, [ 'AND' ]);

        $this->assertEquals('AND', $this->get_reflection_property_value('connector'));
    }

    /**
     * Test creating a simple where/having statement.
     *
     * @param string $keyword   The expected statement keyword
     * @param string $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionCreatesSimpleStatement($keyword, $attribute): void
    {
        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'a', 'b', '=', $keyword ]);

        $string = "$keyword a = b";

        $this->assertEquals($string, $this->get_reflection_property_value($attribute));
    }

    /**
     * Test creating a simple JOIN ON statement.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionCreatesSimpleJoinStatement(): void
    {
        $method = $this->get_accessible_reflection_method('sql_condition');

        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join', 'JOIN table');

        $method->invokeArgs($this->class, [ 'a', 'b', '=', 'ON' ]);

        $string = 'JOIN table ON a = b';

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test creating a simple JOIN ON statement.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionCreatesGroupedJoinStatement(): void
    {
        $method = $this->get_accessible_reflection_method('sql_condition');

        $this->set_reflection_property_value('is_unfinished_join', FALSE);

        $this->set_reflection_property_value('join', 'JOIN table ON (');

        $method->invokeArgs($this->class, [ 'a', 'b', '=', 'ON' ]);

        $string = 'JOIN table ON (a = b';

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test creating a where/having statement with non-default operator.
     *
     * @param string $keyword   The expected statement keyword
     * @param string $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionWithNonDefaultOperator($keyword, $attribute): void
    {
        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'a', 'b', '<', $keyword ]);

        $string = "$keyword a < b";

        $this->assertEquals($string, $this->get_reflection_property_value($attribute));
    }

    /**
     * Test extending a where/having statement with default connector.
     *
     * @param string $keyword   The expected statement keyword
     * @param string $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionExtendingWithDefaultConnector($keyword, $attribute): void
    {
        $string = "$keyword a = b";
        $method = $this->get_accessible_reflection_method('sql_condition');

        $this->set_reflection_property_value($attribute, $string);

        $method->invokeArgs($this->class, [ 'c', 'd', '=', $keyword ]);

        $string = "$keyword a = b AND c = d";

        $this->assertEquals($string, $this->get_reflection_property_value($attribute));
    }

    /**
     * Test extending a where/having statement with a specified connector.
     *
     * @param string $keyword   The expected statement keyword
     * @param string $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionExtendingWithSpecifiedConnector($keyword, $attribute): void
    {
        $string = "$keyword a = b";

        $method = $this->get_accessible_reflection_method('sql_condition');

        $this->set_reflection_property_value('connector', 'OR');
        $this->set_reflection_property_value($attribute, $string);

        $method->invokeArgs($this->class, [ 'c', 'd', '=', $keyword ]);

        $string = "$keyword a = b OR c = d";

        $this->assertEquals($string, $this->get_reflection_property_value($attribute));
    }

    /**
     * Test getting a select query with grouped condition.
     *
     * @param string $keyword   The expected statement keyword
     * @param string $attribute The name of the property where the statement is stored
     *
     * @dataProvider conditionalKeywordProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testGroupedSQLCondition($keyword, $attribute): void
    {
        $method_cond = $this->get_accessible_reflection_method('sql_condition');

        $arguments = [ 'a', 'b', '=', $keyword ];

        $this->set_reflection_property_value($attribute, '(');

        $string = $keyword . ' (a = b';
        $method_cond->invokeArgs($this->class, $arguments);
        $this->assertEquals($string, $this->get_reflection_property_value($attribute));
    }

    /**
     * Test if 'where' works after 'using'.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testWhereWithJoinTypeUsing(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1` USING (column3)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);
        $this->set_reflection_property_value('join_type', 'using');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column4', 'column5', '=', 'WHERE' ]);

        $this->assertSame('INNER JOIN `table1` USING (column3)', $this->get_reflection_property_value('join'));
        $this->assertSame('WHERE column4 = column5', $this->get_reflection_property_value('where'));
    }

    /**
     * Test if 'where' works after 'on'.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testWhereWithJoinTypeOn(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`ON (`column2` = `column3`)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);
        $this->set_reflection_property_value('join_type', 'on');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column4', 'column5', '=', 'WHERE' ]);

        $this->assertSame('INNER JOIN `table1`ON (`column2` = `column3`)', $this->get_reflection_property_value('join'));
        $this->assertSame('WHERE column4 = column5', $this->get_reflection_property_value('where'));
    }

    /**
     * Test if 'where' works with join type empty.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testWhereWithJoinTypeEmpty(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`ON (`column2` = `column3`)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column4', 'column5', '=', 'WHERE' ]);

        $this->assertSame('INNER JOIN `table1`ON (`column2` = `column3`)', $this->get_reflection_property_value('join'));
        $this->assertSame('WHERE column4 = column5', $this->get_reflection_property_value('where'));
    }

    /**
     * Test if 'having' works after 'using'.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testHavingWithJoinTypeUsing(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1` USING (column3)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);
        $this->set_reflection_property_value('join_type', 'using');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column4', 'column5', '=', 'HAVING' ]);

        $this->assertSame('INNER JOIN `table1` USING (column3)', $this->get_reflection_property_value('join'));
        $this->assertSame('HAVING column4 = column5', $this->get_reflection_property_value('having'));
    }

    /**
     * Test if 'having' works after 'on'.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testHavingWithJoinTypeOn(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`ON (`column2` = `column3`)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);
        $this->set_reflection_property_value('join_type', 'on');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column4', 'column5', '=', 'HAVING' ]);

        $this->assertSame('INNER JOIN `table1`ON (`column2` = `column3`)', $this->get_reflection_property_value('join'));
        $this->assertSame('HAVING column4 = column5', $this->get_reflection_property_value('having'));
    }

    /**
     * Test if 'having' works with empty join_type.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testHavingWithJoinTypeEmpty(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`ON (`column2` = `column3`)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column4', 'column5', '=', 'HAVING' ]);

        $this->assertSame('INNER JOIN `table1`ON (`column2` = `column3`)', $this->get_reflection_property_value('join'));
        $this->assertSame('HAVING column4 = column5', $this->get_reflection_property_value('having'));
    }

    /**
     * Test start_on_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartOnGroupWithJoinTypeUsing(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table2` USING (`column1`)');
        $this->set_reflection_property_value('join_type', 'using');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'ON' ]);

        $this->assertSame('INNER JOIN `table2` USING (`column1`)', $this->get_reflection_property_value('join'));
    }

    /**
     * Test start_on_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartOnGroupWithJoinTypeOn(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table2` USING (`column1`)');
        $this->set_reflection_property_value('join_type', 'on');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'ON' ]);

        $this->assertSame('INNER JOIN `table2` USING (`column1`) AND (', $this->get_reflection_property_value('join'));
    }

    /**
     * Test start_on_group() after using join().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartOnGroupWithEmptyJoinType(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'ON' ]);

        $this->assertSame('INNER JOIN `table1`ON (', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test start_having_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartHavingGroupWithJoinTypeUsing(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1` USING (`column1`)');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', 'using');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'having' ]);

        $this->assertSame('INNER JOIN `table1` USING (`column1`)', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test start_having_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartHavingGroupWithJoinTypeOn(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`ON (`column1` = `column2`)');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', 'on');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'having' ]);

        $this->assertSame('INNER JOIN `table1`ON (`column1` = `column2`)', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test start_having_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartHavingGroupWithJoinTypeEmpty(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`ON (`column1` = `column2`)');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'having' ]);

        $this->assertSame('INNER JOIN `table1`ON (`column1` = `column2`)', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test start_having_group() after using join().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartHavingGroupWithJoinTypeEmptyDoesntchangeJoinType(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'having' ]);

        $this->assertSame('', $this->get_reflection_property_value('join_type'));
    }

    /**
     * Test start_where_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartWhereGroupWithJoinTypeUsing(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1` USING (`column1`)');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', 'using');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'where' ]);

        $this->assertSame('INNER JOIN `table1` USING (`column1`)', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test start_where_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartWhereGroupWithJoinTypeOn(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`ON (`column1` = `column2`)');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', 'on');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'where' ]);

        $this->assertSame('INNER JOIN `table1`ON (`column1` = `column2`)', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test start_where_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartWhereGroupWithJoinTypeEmpty(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`ON (`column1` = `column2`)');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'where' ]);

        $this->assertSame('INNER JOIN `table1`ON (`column1` = `column2`)', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test start_where_group() after using join().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartWhereGroupWithJoinTypeEmptyDoesntchangeJoinType(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'where' ]);

        $this->assertSame('', $this->get_reflection_property_value('join_type'));
    }

    /**
     * Test if start_on_group() sets right join type.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartOnGroupSetsRightJoinType(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1` USING (`column1`) INNER JOIN `table2`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'ON' ]);

        $this->assertSame('on', $this->get_reflection_property_value('join_type'));
    }

    /**
     * Test if start_on_group() returns without affecting any data when wrong join_type is active.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartOnGroupReturnsOnWrongJoinType(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1` USING (`column1`) INNER JOIN `table2`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', 'using');
        $join = $this->get_reflection_property_value('join');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'ON' ]);

        $this->assertSame($join, $this->get_reflection_property_value('join'));
    }

    /**
     * Test sql_group_start() if join_type stays using.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_start
     */
    public function testStartOnGroupJoinTypeDoesntChange(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1` USING (`column1`) INNER JOIN `table2`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', 'using');

        $method = $this->get_accessible_reflection_method('sql_group_start');

        $method->invokeArgs($this->class, [ 'ON' ]);

        $this->assertSame('using', $this->get_reflection_property_value('join_type'));
    }

    /**
     * Test end_on_group() after using join()->using()->join()->group_on_start()-on().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_end
     */
    public function testEndOnGroupWithJoinTypeEmpty(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_group_end');

        $method->invokeArgs($this->class, [ 'ON' ]);

        $this->assertSame('INNER JOIN `table1`)', $this->get_reflection_property_value('join'));
    }

    /**
     * Test end_on_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_group_end
     */
    public function testEndOnGroupWithJoinTypeUsing(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table2` USING (`column1`)');
        $this->set_reflection_property_value('join_type', 'using');

        $method = $this->get_accessible_reflection_method('sql_group_end');

        $method->invokeArgs($this->class, [ 'ON' ]);

        $this->assertSame('INNER JOIN `table2` USING (`column1`)', $this->get_reflection_property_value('join'));
    }

    /**
     * Test end_on_group() after using join()->using().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testOnWithJoinTypeUsing(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1` USING (`column1`)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);
        $this->set_reflection_property_value('join_type', 'using');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column2', 'column3', '=', 'ON' ]);

        $this->assertSame('INNER JOIN `table1` USING (`column1`)', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test end_on_group() after using join()-on().
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testOnWithJoinTypeOn(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`ON (`column1` = `column2`)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);
        $this->set_reflection_property_value('join_type', 'on');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column2', 'column3', '=', 'ON' ]);

        $this->assertSame('INNER JOIN `table1`ON (`column1` = `column2`) AND column2 = column3', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test on() with empty join type.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testOnWithJoinTypeEmpty(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column2', 'column3', '=', 'ON' ]);

        $this->assertSame('INNER JOIN `table1` ON column2 = column3', $this->get_reflection_property_value('join'));
        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test if sql_condition() returns without affecting any data when wrong join_type is active.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testOnWithJoinTypeUsingDoesntChangeJoinType(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1` USING (`column1`)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);
        $this->set_reflection_property_value('join_type', 'using');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column2', 'column3', '=', 'ON' ]);

        $this->assertSame('using', $this->get_reflection_property_value('join_type'));
    }

    /**
     * Test if sql_condition() finishes join.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testOnSettingFinishedJoin(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column2', 'column3', '=', 'ON' ]);

        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test if sql_condition() finishes join.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testWhereSettingFinishedJoin(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column2', 'column3', '=', 'WHERE' ]);

        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test if sql_condition() finishes join.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testHavingSettingFinishedJoin(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column2', 'column3', '=', 'WHERE' ]);

        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test if sql_condition() sets right join_type.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testOnSetRightJoinType(): void
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table1`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);
        $this->set_reflection_property_value('join_type', '');

        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'column2', 'column3', '=', 'ON' ]);

        $this->assertSame('on', $this->get_reflection_property_value('join_type'));
    }

}

?>
