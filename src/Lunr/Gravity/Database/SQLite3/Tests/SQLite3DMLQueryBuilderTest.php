<?php

/**
 * This file contains the SQLite3DMLQueryBuilderTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the SQLite3DMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
abstract class SQLite3DMLQueryBuilderTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->class = new SQLite3DMLQueryBuilder();

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder');
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
     * Unit Test Data Provider for Select modes handling duplicate result entries.
     *
     * @return array $modes Array of select modes
     */
    public function selectModesDuplicatesProvider()
    {
        $modes   = [];
        $modes[] = [ 'ALL' ];
        $modes[] = [ 'DISTINCT' ];

        return $modes;
    }

    /**
     * Unit Test Data Provider for standard Select modes.
     *
     * @return array $modes Array of select modes
     */
    public function modesProvider()
    {
        $modes   = [];
        $modes[] = [ 'OR ROLLBACK' ];
        $modes[] = [ 'OR IGNORE' ];
        $modes[] = [ 'OR ABORT' ];
        $modes[] = [ 'OR REPLACE' ];
        $modes[] = [ 'OR FAIL' ];

        return $modes;
    }

    /**
     * Unit Test Data Provider for Insert modes uppercasing.
     *
     * @return array $expectedmodes Array of insert modes and their expected result
     */
    public function expectedModesProvider()
    {
        $expectedmodes   = [];
        $expectedmodes[] = [ 'or rollback', 'OR ROLLBACK' ];
        $expectedmodes[] = [ 'or abort', 'OR ABORT' ];
        $expectedmodes[] = [ 'or ignore', 'OR IGNORE' ];
        $expectedmodes[] = [ 'or replace', 'OR REPLACE' ];
        $expectedmodes[] = [ 'or fail', 'OR FAIL' ];

        return $expectedmodes;
    }

}

?>
