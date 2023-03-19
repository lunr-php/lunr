<?php

/**
 * This file contains the SQLite3ConnectionBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3Connection;

/**
 * This class contains basic tests for the SQLite3Connection class.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection
 */
class SQLite3ConnectionBaseTest extends SQLite3ConnectionTest
{

    /**
     * Test that the SQLite3 class was passed correctly.
     */
    public function testSQLite3Passed(): void
    {
        $value = $this->get_reflection_property_value('sqlite3');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\LunrSQLite3', $value);
    }

    /**
     * Test that database is set correctly.
     */
    public function testDatabaseIsSetCorrectly(): void
    {
        $this->assertEquals('/tmp/test.db', $this->get_reflection_property_value('db'));
    }

    /**
     * Test that get_new_dml_query_builder_object() returns a new object.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::get_new_dml_query_builder_object
     */
    public function testGetNewDMLQueryBuilderObjectReturnsObject(): void
    {
        $value = $this->class->get_new_dml_query_builder_object();

        $this->assertInstanceOf('Lunr\Gravity\Database\DatabaseDMLQueryBuilder', $value);
        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $value);
    }

    /**
     * Test that get_query_escaper_object() returns a new object.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::get_query_escaper_object
     */
    public function testGetQueryEscaperObjectReturnsObject(): void
    {
        $value = $this->class->get_query_escaper_object();

        $this->assertInstanceOf('Lunr\Gravity\Database\DatabaseQueryEscaper', $value);
        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper', $value);
    }

    /**
     * Test that get_query_escaper_object() returns a new object.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::get_query_escaper_object
     */
    public function testGetQueryEscaperObjectCachesObject(): void
    {
        $property = $this->get_accessible_reflection_property('escaper');
        $this->assertNull($property->getValue($this->class));

        $this->class->get_query_escaper_object();

        $instance = 'Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper';
        $this->assertInstanceOf($instance, $property->getValue($this->class));
    }

    /**
     * Test that get_query_escaper_object() returns a new object.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::get_query_escaper_object
     */
    public function testGetQueryEscaperObjectReturnsCachedObject(): void
    {
        $value1 = $this->class->get_query_escaper_object();
        $value2 = $this->class->get_query_escaper_object();

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper', $value1);
        $this->assertSame($value1, $value2);
    }

    /**
     * Test that get_database() returns the database name.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::get_database
     */
    public function testGetDatabase(): void
    {
        $value = $this->class->get_database();

        $this->assertSame('/tmp/test.db', $value);
    }

}

?>
