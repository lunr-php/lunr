<?php

/**
 * This file contains the MariaDBDMLQueryBuilderTest class.
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MariaDBDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder
 */
abstract class MariaDBDMLQueryBuilderTest extends TestCase
{

    /**
     * Instance of the MySQLQueryBuilder class.
     * @var MySQLDMLQueryBuilder
     */
    protected $builder;

    /**
     * Reflection instance of the MariaDBDMLQueryBuilder class.
     * @var ReflectionClass
     */
    protected $builder_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->builder            = new MariaDBDMLQueryBuilder();
        $this->builder_reflection = new ReflectionClass('Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->builder);
        unset($this->builder_reflection);
    }

}
