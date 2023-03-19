<?php

/**
 * This file contains the MariaDBDMLQueryBuilderDeleteTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
    public function testDeleteWithReturning($value, $expected): void
    {
        $property = $this->reflection->getProperty('returning');
        $property->setAccessible(TRUE);

        $this->class->returning($value);

        $this->assertStringMatchesFormat($expected, $property->getValue($this->class));
    }

    /**
     * Unit Test Data Provider for delete returning statements.
     *
     * @return array $expectedReturn
     */
    public function expectedReturningDataProvider(): array
    {
        $expected_return   = [];
        $expected_return[] = [ '*', 'RETURNING *' ];
        $expected_return[] = [ 'id, name', 'RETURNING id, name' ];
        $expected_return[] = [ "'test'", "RETURNING 'test'" ];

        return $expected_return;
    }

}

?>
