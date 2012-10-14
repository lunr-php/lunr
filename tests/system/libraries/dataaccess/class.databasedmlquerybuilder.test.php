<?php

/**
 * This file contains the DatabaseDMLQueryBuilderTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the DatabaseDMLQueryBuilder class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder
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
        $this->builder = $this->getMockForAbstractClass('Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder');

        $this->builder_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder');
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
     * Unit test data provider for column names.
     *
     * @return array $cols Array of column names and expected escaped values.
     */
    public function columnNameProvider()
    {
        $cols   = array();
        $cols[] = array('*', '*');
        $cols[] = array('table.*', '`table`.*');
        $cols[] = array('col', '`col`');
        $cols[] = array('table.col', '`table`.`col`');
        $cols[] = array('db.table.col', '`db`.`table`.`col`');

        return $cols;
    }

    /**
     * Unit test data provider for table names.
     *
     * @return array $cols Array of table names and expected escaped values.
     */
    public function tableNameProvider()
    {
        $cols   = array();
        $cols[] = array('table', '`table`');
        $cols[] = array('db.table', '`db`.`table`');

        return $cols;
    }

    /**
     * Unit test data provider for where or having statements.
     *
     * @return array $variants Array of statement variants
     */
    public function whereOrHavingProvider()
    {
        $variants   = array();
        $variants[] = array(TRUE, 'WHERE');
        $variants[] = array(FALSE, 'HAVING');

        return $variants;
    }

}

?>
