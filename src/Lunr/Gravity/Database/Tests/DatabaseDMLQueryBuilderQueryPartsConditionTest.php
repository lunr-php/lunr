<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsConditionTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts methods.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsConditionTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying a logical connector for the query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_connector
     */
    public function testConnector()
    {
        $method = $this->get_accessible_reflection_method('sql_connector');

        $method->invokeArgs($this->class, [ 'AND' ]);

        $this->assertEquals('AND', $this->get_reflection_property_value('connector'));
    }

    /**
    * Test creating a simple where/having statement.
    *
    * @param String $keyword   The expected statement keyword
    * @param String $attribute The name of the property where the statement is stored
    *
    * @dataProvider ConditionalKeywordProvider
    * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
    */
    public function testConditionCreatesSimpleStatement($keyword, $attribute)
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
    public function testConditionCreatesSimpleJoinStatement()
    {
        $method = $this->get_accessible_reflection_method('sql_condition');

        $this->set_reflection_property_value('is_join', TRUE);
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
    public function testConditionCreatesGroupedJoinStatement()
    {
        $method = $this->get_accessible_reflection_method('sql_condition');

        $this->set_reflection_property_value('is_join', FALSE);

        $this->set_reflection_property_value('join', 'JOIN table ON (');

        $method->invokeArgs($this->class, array('a', 'b', '=', 'ON'));

        $string = 'JOIN table ON (a = b';

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test creating a where/having statement with non-default operator.
     *
     * @param String $keyword   The expected statement keyword
     * @param String $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionWithNonDefaultOperator($keyword, $attribute)
    {
        $method = $this->get_accessible_reflection_method('sql_condition');

        $method->invokeArgs($this->class, [ 'a', 'b', '<', $keyword ]);

        $string = "$keyword a < b";

        $this->assertEquals($string, $this->get_reflection_property_value($attribute));
    }

    /**
     * Test extending a where/having statement with default connector.
     *
     * @param String $keyword   The expected statement keyword
     * @param String $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionExtendingWithDefaultConnector($keyword, $attribute)
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
     * @param String $keyword   The expected statement keyword
     * @param String $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionExtendingWithSpecifiedConnector($keyword, $attribute)
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
    * @param String $keyword   The expected statement keyword
    * @param String $attribute The name of the property where the statement is stored
    *
    * @dataProvider conditionalKeywordProvider
    * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_condition
    */
    public function testGroupedSQLCondition($keyword, $attribute)
    {
        $method_cond = $this->get_accessible_reflection_method('sql_condition');

        $arguments = array('a', 'b', '=', $keyword);

        $this->set_reflection_property_value($attribute, '(');

        $string = $keyword . ' (a = b';
        $method_cond->invokeArgs($this->class, $arguments);
        $this->assertEquals($string, $this->get_reflection_property_value($attribute));
    }

}

?>
