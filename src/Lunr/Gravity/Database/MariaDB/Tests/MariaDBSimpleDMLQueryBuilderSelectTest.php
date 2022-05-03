<?php

/**
 * This file contains the MariaDBSimpleDMLQueryBuilderSelectTest class.
 *
 * @package   Lunr\Gravity\Database\MariaDB
 * @author    David Cova <d.cova@m2mobi.com>
 * @copyright 2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

/**
 * This class contains select tests for the MariaDBSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder
 */
class MariaDBSimpleDMLQueryBuilderSelectTest extends MariaDBSimpleDMLQueryBuilderTest
{

    /**
     * Test intersect().
     *
     * @dataProvider compoundOperatorProvider
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder::intersect
     */
    public function testIntersect($operators): void
    {
        $this->escaper->expects($this->once())
                      ->method('query_value')
                      ->with('query')
                      ->willReturn('(query)');

        $this->builder->expects($this->once())
                      ->method('intersect')
                      ->with('(query)', $operators)
                      ->willReturnSelf();

        $this->class->intersect('query', $operators);
    }

    /**
     * Test except().
     *
     * @dataProvider compoundOperatorProvider
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder::except
     */
    public function testExcept($operators): void
    {
        $this->escaper->expects($this->once())
                      ->method('query_value')
                      ->with('query')
                      ->willReturn('(query)');

        $this->builder->expects($this->once())
                      ->method('except')
                      ->with('(query)', $operators)
                      ->willReturnSelf();

        $this->class->except('query', $operators);
    }

}

?>
