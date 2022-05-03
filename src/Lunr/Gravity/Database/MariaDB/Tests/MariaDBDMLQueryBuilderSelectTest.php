<?php

/**
 * This file contains the MariaDBDMLQueryBuilderSelectTest class.
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     David Cova <d.cova@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use Lunr\Gravity\Database\MariaDB\Tests\MariaDBDMLQueryBuilderTest;
/**
 * This class contains select tests for the MariaDBDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder
 */
class MariaDBDMLQueryBuilderSelectTest extends MariaDBDMLQueryBuilderTest
{

     /**
     * Test if except returns an instance of itself.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder::except
     */
    public function testIfExceptReturnsSelfReference(): void
    {
        $return = $this->builder->except('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test if intersect returns an instance of itself.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder::intersect
     */
    public function testIfIntersectReturnsSelfReference(): void
    {
        $return = $this->builder->intersect('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test if intersect() defaults to INTERSECT when a string other than DISTINCT or ALL is passed.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder::intersect
     */
    public function testIntersectDefaults()
    {
        $this->builder->intersect('query', 'random_string');
        $return = $this->builder_reflection->getProperty('compound');
        $return->setAccessible(TRUE);

        $actual = $return->getValue($this->builder);
        $this->assertEquals('INTERSECT query', $actual);
    }

    /**
     * Test if intersect() returns INTERSECT DISTINCT when DISTINCT is passed.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder::intersect
     */
    public function testIntersectDistinct()
    {
        $this->builder->intersect('query', 'distinct');
        $return = $this->builder_reflection->getProperty('compound');
        $return->setAccessible(TRUE);

        $actual = $return->getValue($this->builder);
        $this->assertEquals('INTERSECT DISTINCT query', $actual);
    }

    /**
     * Test if intersect() returns INTERSECT ALL when ALL is passed.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder::intersect
     */
    public function testIntersectAll()
    {
        $this->builder->intersect('query', 'all');
        $return = $this->builder_reflection->getProperty('compound');
        $return->setAccessible(TRUE);

        $actual = $return->getValue($this->builder);
        $this->assertEquals('INTERSECT ALL query', $actual);
    }

    /**
     * Test if except() defaults to EXCEPT when a string other than DISTINCT or ALL is passed.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder::except
     */
    public function testExceptDefaults()
    {
        $this->builder->except('query', 'random_string');
        $return = $this->builder_reflection->getProperty('compound');
        $return->setAccessible(TRUE);

        $actual = $return->getValue($this->builder);
        $this->assertEquals('EXCEPT query', $actual);
    }

    /**
     * Test if except() returns EXCEPT DISTINCT when DISTINCT is passed.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder::except
     */
    public function testExceptDistinct()
    {
        $this->builder->except('query', 'DISTINCT');
        $return = $this->builder_reflection->getProperty('compound');
        $return->setAccessible(TRUE);

        $actual = $return->getValue($this->builder);
        $this->assertEquals('EXCEPT DISTINCT query', $actual);
    }

    /**
     * Test if except() returns EXCEPT ALL when ALL is passed.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder::except
     */
    public function testExceptAll()
    {
        $this->builder->except('query', 'all');
        $return = $this->builder_reflection->getProperty('compound');
        $return->setAccessible(TRUE);

        $actual = $return->getValue($this->builder);
        $this->assertEquals('EXCEPT ALL query', $actual);
    }

}

?>
