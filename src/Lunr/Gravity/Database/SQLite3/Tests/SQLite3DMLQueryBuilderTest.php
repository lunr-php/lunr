<?php

/**
 * This file contains the SQLite3DMLQueryBuilderTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
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
        $modes   = array();
        $modes[] = array('ALL');
        $modes[] = array('DISTINCT');

        return $modes;
    }

    /**
     * Unit Test Data Provider for standard Select modes.
     *
     * @return array $modes Array of select modes
     */
    public function modesProvider()
    {
        $modes   = array();
        $modes[] = array('OR ROLLBACK');
        $modes[] = array('OR IGNORE');
        $modes[] = array('OR ABORT');
        $modes[] = array('OR REPLACE');
        $modes[] = array('OR FAIL');

        return $modes;
    }

    /**
     * Unit Test Data Provider for Insert modes uppercasing.
     *
     * @return array $expectedmodes Array of insert modes and their expected result
     */
    public function expectedModesProvider()
    {
        $expectedmodes   = array();
        $expectedmodes[] = array('or rollback', 'OR ROLLBACK');
        $expectedmodes[] = array('or abort', 'OR ABORT');
        $expectedmodes[] = array('or ignore', 'OR IGNORE');
        $expectedmodes[] = array('or replace', 'OR REPLACE');
        $expectedmodes[] = array('or fail', 'OR FAIL');

        return $expectedmodes;
    }

}

?>
