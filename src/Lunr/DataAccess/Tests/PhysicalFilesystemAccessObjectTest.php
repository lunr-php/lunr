<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\PhysicalFilesystemAccessObject;
use Psr\Log\LoggerInterface;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use stdClass;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the PhysicalFilesystemAccessObject class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\PhysicalFilesystemAccessObject
 */
abstract class PhysicalFilesystemAccessObjectTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the PhysicalFilesystemAccessObject class.
     * @var PhysicalFilesystemAccessObject
     */
    protected $class;

    /**
     * Reflection instance of the PhysicalFilesystemAccessObject class.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Location used for file finding tests.
     * @var String
     */
    protected $find_location;

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->logger        = $this->getMock('Psr\Log\LoggerInterface');
        $this->class         = new PhysicalFilesystemAccessObject($this->logger);
        $this->reflection    = new ReflectionClass('Lunr\DataAccess\PhysicalFilesystemAccessObject');
        $this->find_location = __DIR__ . '/../../../../tests/statics/fao';
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->logger);
        unset($this->find_location);
    }

    /**
     * Unit test data provider for invalid file or directory names.
     *
     * @return array $names Array of invalid names,
     */
    public function invalidNameProvider()
    {
        $names   = array();
        $names[] = array(NULL, 'SplFileObject::__construct(): Filename cannot be empty');
        $names[] = array(new stdClass(), 'SplFileObject::__construct() expects parameter 1 to be a valid path, object given');

        return $names;
    }

    /**
     * Unit test data provider for boolean file or directory names.
     *
     * @return array $names Array of boolean names,
     */
    public function booleanNameProvider()
    {
        $names   = array();
        $names[] = array(TRUE);
        $names[] = array(FALSE);

        return $names;
    }

    /**
     * Unit test data provider for invalid file open modes.
     *
     * @return array $modes Array of invalid modes,
     */
    public function invalidModesProvider()
    {
        $modes   = array();
        $modes[] = array(NULL, ': failed to open stream: No such file or directory');
        $modes[] = array(new stdClass(), ' expects parameter 2 to be string, object given');
        $modes[] = array(TRUE, ': failed to open stream: No such file or directory');
        $modes[] = array(FALSE, ': failed to open stream: No such file or directory');

        return $modes;
    }

}

?>
