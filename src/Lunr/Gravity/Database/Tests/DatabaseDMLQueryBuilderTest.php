<?php

/**
 * This file contains the DatabaseDMLQueryBuilderTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use stdClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the DatabaseDMLQueryBuilder class.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
abstract class DatabaseDMLQueryBuilderTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->class = $this->getMockForAbstractClass('Lunr\Gravity\Database\DatabaseDMLQueryBuilder');

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseDMLQueryBuilder');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit test data provider for conditional statements.
     *
     * @return array $variants Array of statement variants
     */
    public function conditionalKeywordProvider()
    {
        $variants   = [];
        $variants[] = [ 'WHERE', 'where' ];
        $variants[] = [ 'HAVING', 'having' ];
        $variants[] = [ 'ON', 'join' ];

        return $variants;
    }

    /**
     * Unit test data provider for common join types.
     *
     * @return array $variants Array of join types
     */
    public function commonJoinTypeProvider()
    {
        $types   = [];
        $types[] = [ '', 'JOIN' ];
        $types[] = [ 'LEFT', 'LEFT JOIN' ];
        $types[] = [ 'LEFT OUTER', 'LEFT OUTER JOIN' ];
        $types[] = [ 'NATURAL LEFT OUTER', 'NATURAL LEFT OUTER JOIN' ];

        return $types;
    }

    /**
     * Unit test data provider for valid index hints.
     *
     * @return array $hints Array of valid index hints and exptected prepared values
     */
    public function validIndexHintProvider()
    {
        $hints   = [];
        $hints[] = [ [ 'index_hint' ], ' index_hint' ];
        $hints[] = [ [ 'index_hint', 'index_hint' ], ' index_hint, index_hint' ];
        $hints[] = [ [ NULL ], ' ' ];
        $hints[] = [ [ NULL, NULL ], ' ' ];

        return $hints;
    }

    /**
     * Unit test data provider for invalid index hints.
     *
     * @return array $hints Array of invalid index hints
     */
    public function invalidIndexHintProvider()
    {
        $hints   = [];
        $hints[] = [[]];
        $hints[] = [ NULL ];
        $hints[] = [ FALSE ];
        $hints[] = [ 1 ];
        $hints[] = [ 'string' ];
        $hints[] = [ new stdClass() ];

        return $hints;
    }

    /**
    * Unit test data provider for common compound queries.
    *
    * @return array $compound Array of compound types
    */
    public function compoundQueryTypeProvider()
    {
        $types   = [];
        $types[] = [ 'UNION' ];
        $types[] = [ 'UNION ALL' ];
        $types[] = [ 'EXCEPT' ];
        $types[] = [ 'INTERSECT' ];

        return $types;
    }

}

?>
