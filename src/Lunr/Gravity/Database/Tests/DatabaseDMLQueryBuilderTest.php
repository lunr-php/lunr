<?php

/**
 * This file contains the DatabaseDMLQueryBuilderTest class.
 *
 * PHP Version 5.3
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
use PHPUnit_Framework_TestCase;
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
abstract class DatabaseDMLQueryBuilderTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the DatabaseQueryBuilder class.
     * @var DatabaseDMLQueryBuilder
     */
    protected $builder;

    /**
     * Reflection instance of the DatabaseDMLQueryBuilder class.
     * @var ReflectionClass
     */
    protected $builder_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->builder = $this->getMockForAbstractClass('Lunr\Gravity\Database\DatabaseDMLQueryBuilder');

        $this->builder_reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseDMLQueryBuilder');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->builder);
        unset($this->builder_reflection);
    }

    /**
     * Unit test data provider for conditional statements.
     *
     * @return array $variants Array of statement variants
     */
    public function conditionalKeywordProvider()
    {
        $variants   = array();
        $variants[] = array('WHERE', 'where');
        $variants[] = array('HAVING', 'having');
        $variants[] = array('ON', 'join');

        return $variants;
    }

    /**
     * Unit test data provider for common join types.
     *
     * @return array $variants Array of join types
     */
    public function commonJoinTypeProvider()
    {
        $types   = array();
        $types[] = array('', 'JOIN');
        $types[] = array('LEFT', 'LEFT JOIN');
        $types[] = array('LEFT OUTER', 'LEFT OUTER JOIN');
        $types[] = array('NATURAL LEFT OUTER', 'NATURAL LEFT OUTER JOIN');

        return $types;
    }

    /**
     * Unit test data provider for valid index hints.
     *
     * @return array $hints Array of valid index hints and exptected prepared values
     */
    public function validIndexHintProvider()
    {
        $hints   = array();
        $hints[] = array(array('index_hint'), ' index_hint');
        $hints[] = array(array('index_hint', 'index_hint'), ' index_hint, index_hint');
        $hints[] = array(array(NULL), ' ');
        $hints[] = array(array(NULL, NULL), ' ');

        return $hints;
    }

    /**
     * Unit test data provider for invalid index hints.
     *
     * @return array $hints Array of invalid index hints
     */
    public function invalidIndexHintProvider()
    {
        $hints   = array();
        $hints[] = array(array());
        $hints[] = array(NULL);
        $hints[] = array(FALSE);
        $hints[] = array(1);
        $hints[] = array('string');
        $hints[] = array(new stdClass());

        return $hints;
    }

    /**
    * Unit test data provider for common compound queries.
    *
    * @return array $compound Array of compound types
    */
    public function compoundQueryTypeProvider()
    {
        $types   = array();
        $types[] = array('UNION');
        $types[] = array('UNION ALL');
        $types[] = array('EXCEPT');
        $types[] = array('INTERSECT');

        return $types;
    }

}

?>
