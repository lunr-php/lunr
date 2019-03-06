<?php

/**
 * This file contains the MariaDBDMLQueryBuilderDeleteTest class.
 *
 * PHP Version 7.0
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * delete queries.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder
 */
class MariaDBDMLQueryBuilderDeleteTest extends MariaDBDMLQueryBuilderTest
{

    /**
     * Test delete with returning statement.
     *
     * @param string $value    Returning value
     * @param string $expected Expected built query part
     *
     * @dataProvider expectedReturningDataProvider
     * @covers       Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder::returning
     */
    public function testDeleteWithReturning($value, $expected)
    {
        $property = $this->builder_reflection->getProperty('returning');
        $property->setAccessible(TRUE);

        $this->builder->returning($value);

        $this->assertContains($expected, $property->getValue($this->builder));
    }

    /**
     * Unit Test Data Provider for delete returning statements.
     *
     * @return array $expectedReturn
     */
    public function expectedReturningDataProvider()
    {
        $expected_return   = [];
        $expected_return[] = ['*', 'RETURNING *'];
        $expected_return[] = ['id, name', 'RETURNING id, name'];
        $expected_return[] = ["'test'", "RETURNING 'test'"];

        return $expected_return;
    }

}

?>
