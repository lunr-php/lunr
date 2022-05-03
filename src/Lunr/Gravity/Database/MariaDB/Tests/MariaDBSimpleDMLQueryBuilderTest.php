<?php

/**
 * This file contains the MariaDBSimpleDMLQueryBuilderTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Lunr\Gravity\Database\MySQL\MySQLQueryEscaper;
use Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder;
use Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MariaDBSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MMariaDBSimpleDMLQueryBuilder
 */
abstract class MariaDBSimpleDMLQueryBuilderTest extends TestCase
{

    /**
     * MySQL query escaper instance.
     * @var MySQLQueryEscaper
     */
    protected $escaper;

    /**
     * Instance of the simple  query builder.
     * @var MariaDBDMLQueryBuilder
     */
    protected $builder;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->escaper = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->builder = $this->getMockBuilder('Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder')
                              ->getMock();

        $this->class      = new MariaDBSimpleDMLQueryBuilder($this->builder, $this->escaper);
        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->escaper);
        unset($this->builder);
        unset($this->reflection);
        unset($this->class);
    }

    /**
    * Unit test data provider for tested union operators.
    *
    * @return array $compound operators for union query
    */
    public function compoundOperatorProvider(): array
    {
        $operators   = [];
        $operators[] = [ NULL ];
        $operators[] = [ 'ALL' ];
        $operators[] = [ 'DISTINCT' ];
        $operators[] = [ TRUE ];
        $operators[] = [ FALSE ];

        return $operators;
    }

}

?>
