<?php

/**
 * This file contains the MySQLDMLQueryBuilderTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MySQLDMLQueryBuilder class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder
 */
abstract class MySQLDMLQueryBuilderTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the MySQLQueryBuilder class.
     * @var MySQLDMLQueryBuilder
     */
    protected $builder;

    /**
     * Reflection instance of the MySQLDMLQueryBuilder class.
     * @var ReflectionClass
     */
    protected $builder_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->builder = new MySQLDMLQueryBuilder();

        $this->builder_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder');
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
     * Unit Test Data Provider for Select modes handling duplicate result entries.
     *
     * @return array $modes Array of select modes
     */
    public function selectModesDuplicatesProvider()
    {
        $modes   = array();
        $modes[] = array('ALL');
        $modes[] = array('DISTINCT');
        $modes[] = array('DISTINCTROW');

        return $modes;
    }

    /**
     * Unit Test Data Provider for Select modes handling the sql query cache.
     *
     * @return array $modes Array of select modes
     */
    public function selectModesCacheProvider()
    {
        $modes   = array();
        $modes[] = array('SQL_CACHE');
        $modes[] = array('SQL_NO_CACHE');

        return $modes;
    }

    /**
     * Unit Test Data Provider for standard Select modes.
     *
     * @return array $modes Array of select modes
     */
    public function selectModesStandardProvider()
    {
        $modes   = array();
        $modes[] = array('HIGH_PRIORITY');
        $modes[] = array('STRAIGHT_JOIN');
        $modes[] = array('SQL_BIG_RESULT');
        $modes[] = array('SQL_SMALL_RESULT');
        $modes[] = array('SQL_BUFFER_RESULT');
        $modes[] = array('SQL_CALC_FOUND_ROWS');

        return $modes;
    }

}

?>
