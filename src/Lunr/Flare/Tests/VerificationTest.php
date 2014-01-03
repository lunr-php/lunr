<?php

/**
 * This file contains the VerificationTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Flare\Tests;

use Lunr\Flare\Verification;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use stdClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Verification class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Flare\Verification
 */
abstract class VerificationTest extends LunrBaseTest
{

    /**
     * Mock instance of the Logger class.
     * @var Logger
     */
    protected $logger;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->class = new Verification($this->logger);

        $this->reflection = new ReflectionClass('Lunr\Flare\Verification');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Unit Test Data Provider for valid type checks.
     *
     * @return array $types Array of valid type=>value combinations
     */
    public function validTypeProvider()
    {
        $types   = array();
        $types[] = array('array', array());
        $types[] = array('bool', TRUE);
        $types[] = array('double', 1.5);
        $types[] = array('float', 1.5);
        $types[] = array('int', 1);
        $types[] = array('integer', 1);
        $types[] = array('long', 1);
        $types[] = array('null', NULL);
        $types[] = array('numeric', '1');
        $types[] = array('object', new stdClass());
        $types[] = array('real', 1.5);
        $types[] = array('scalar', '1');
        $types[] = array('string', 'string');

        return $types;
    }

    /**
     * Unit Test Data Provider for invalid type checks.
     *
     * @return array $types Array of invalid type=>value combinations
     */
    public function invalidTypeProvider()
    {
        $types   = array();
        $types[] = array('array', NULL);
        $types[] = array('bool', 1);
        $types[] = array('double', 2);
        $types[] = array('float', 2);
        $types[] = array('int', 1.5);
        $types[] = array('integer', 1.5);
        $types[] = array('long', 1.5);
        $types[] = array('null', FALSE);
        $types[] = array('numeric', 's');
        $types[] = array('object', array());
        $types[] = array('real', 2);
        $types[] = array('scalar', NULL);
        $types[] = array('string', 1.5);

        return $types;
    }

    /**
     * Unit Test Data Provider for empty values.
     *
     * @return array $values Set of empty values
     */
    public function emptyValueProvider()
    {
        $values   = array();
        $values[] = array('');
        $values[] = array(0);
        $values[] = array(0.0);
        $values[] = array('0');
        $values[] = array(NULL);
        $values[] = array(FALSE);
        $values[] = array(array());

        return $values;
    }

    /**
     * Unit Test Data Provider for valid numerical booleans.
     *
     * @return array $bools Set of numerical booleans.
     */
    public function validNumericalBooleanProvider()
    {
        $bools   = array();
        $bools[] = array(0);
        $bools[] = array(1);
        $bools[] = array('0');
        $bools[] = array('1');

        return $bools;
    }

    /**
     * Unit Test Data Provider for valid numerical trooleans.
     *
     * @return array $bools Set of numerical trooleans.
     */
    public function validNumericalTrooleanProvider()
    {
        $bools   = $this->validNumericalBooleanProvider();
        $bools[] = array(2);
        $bools[] = array('2');

        return $bools;
    }

    /**
     * Unit Test Data Provider for invalid numerical trooleans.
     *
     * @return array $trools Set of invalid numerical trooleans.
     */
    public function invalidNumericalTrooleanProvider()
    {
        $trools   = array();
        $trools[] = array(3);
        $trools[] = array('3');
        $trools[] = array(TRUE);
        $trools[] = array(FALSE);

        return $trools;
    }

    /**
     * Unit Test Data Provider for invalid numerical booleans.
     *
     * @return array $bools Set of invalid numerical booleans.
     */
    public function invalidNumericalBooleanProvider()
    {
        $bools   = $this->invalidNumericalTrooleanProvider();
        $bools[] = array(2);
        $bools[] = array('2');

        return $bools;
    }

    /**
     * Unit Test Data Provider for invalid datasets.
     *
     * @return array $set Set of invalid dataset values
     */
    public function invalidDatasetProvider()
    {
        $sets   = array();
        $sets[] = array(FALSE);
        $sets[] = array(array());
        $sets[] = array('string');

        return $sets;
    }

    /**
     * Unit Test Data Provider for datasets that have been fully checked.
     *
     * @return array $data Set of data and results
     */
    public function isFullyCheckedProvider()
    {
        $data   = array();
        $data[] = array(array(), array());
        $data[] = array(array('test' => 'value'), array('test' => TRUE));

        return $data;
    }

    /**
     * Unit Test Data Provider for datasets that have not been fully checked.
     *
     * @return array $data Set of data and results
     */
    public function isNotFullyCheckedProvider()
    {
        $data   = array();
        $data[] = array(array('test' => 'value'), array());
        $data[] = array(array('test' => 'value', 'ing' => 'string'), array('test' => TRUE));

        return $data;
    }

}

?>
