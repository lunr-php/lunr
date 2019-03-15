<?php

/**
 * This file contains the MariaDMLQueryBuilderTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MariaDBDMLQueryBuilder class.
 *
 * @covers \Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder
 */
abstract class MariaDBDMLQueryBuilderTest extends TestCase
{
    /**
     * Instance of the MariaDBDMLQueryBuilder class.
     * @var MariaDBDMLQueryBuilder
     */
    protected $builder;

    /**
     * Reflection class of the MariaDBDMLQueryBuilder.
     * @var ReflectionClass
     */
    protected $builder_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->builder            = new MariaDBDMLQueryBuilder();
        $this->builder_reflection = new ReflectionClass('Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->builder);
        unset($this->builder_reflection);
    }

}

?>
