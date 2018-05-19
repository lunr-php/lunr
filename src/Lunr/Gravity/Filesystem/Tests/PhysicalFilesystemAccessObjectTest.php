<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

use Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject;
use Psr\Log\LoggerInterface;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use stdClass;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the PhysicalFilesystemAccessObject class.
 *
 * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
abstract class PhysicalFilesystemAccessObjectTest extends LunrBaseTest
{

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
        $this->logger        = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $this->class         = new PhysicalFilesystemAccessObject($this->logger);
        $this->reflection    = new ReflectionClass('Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject');
        $this->find_location = TEST_STATICS . '/Gravity';
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
        $names   = [];
        $names[] = [NULL, 'SplFileObject::__construct(): Filename cannot be empty'];
        $names[] = [new stdClass(), 'SplFileObject::__construct() expects parameter 1 to be a valid path, object given'];

        return $names;
    }

    /**
     * Unit test data provider for boolean file or directory names.
     *
     * @return array $names Array of boolean names,
     */
    public function booleanNameProvider()
    {
        $names   = [];
        $names[] = [TRUE];
        $names[] = [FALSE];

        return $names;
    }

    /**
     * Unit test data provider for invalid file open modes.
     *
     * @return array $modes Array of invalid modes,
     */
    public function invalidModesProvider()
    {
        $modes   = [];
        $modes[] = [NULL, ': failed to open stream: No such file or directory'];
        $modes[] = [new stdClass(), ' expects parameter 2 to be string, object given'];
        $modes[] = [TRUE, ': failed to open stream: No such file or directory'];
        $modes[] = [FALSE, ': failed to open stream: No such file or directory'];

        return $modes;
    }

    /**
     * Unit test data provider for empty filepath values.
     *
     * @return array $filepath Array of invalid filepaths
     */
    public function emptyFilepathValueProvider()
    {
        $filepath   = [];
        $filepath[] = [NULL];
        $filepath[] = [FALSE];

        return $filepath;
    }

    /**
     * Unit test data provider for invalid filepath values.
     *
     * @return array $filepath Array of invalid filepaths
     */
    public function invalidFilepathValueProvider()
    {
        $filepath   = [];
        $filepath[] = ['/tmp56474q', 'RecursiveDirectoryIterator::__construct(/tmp56474q): failed to open dir: No such file or directory'];
        $filepath[] = ['/root', 'RecursiveDirectoryIterator::__construct(/root): failed to open dir: Permission denied'];
        $filepath[] = [new stdClass(), 'RecursiveDirectoryIterator::__construct() expects parameter 1 to be string, object given'];

        return $filepath;
    }

    /**
     * Unit test data provider for invalid array values.
     *
     * @return array $values Array of invalid values
     */
    public function invalidCSVArrayValues()
    {
        $values   = [];
        $values[] = [ NULL ];
        $values[] = [ FALSE ];

        return $values;
    }

    /**
     * Unit test data provider for invalid access mode values.
     *
     * @return array $modes Array of invalid values
     */
    public function invalidDirModeValues()
    {
        $modes   = [];
        $modes[] = [ -1 ];
        $modes[] = [ 1536 ];
        $modes[] = [ 5000 ];

        return $modes;
    }

    /**
     * Unit test data provider for valid access mode values.
     *
     * @return array $modes Array of valid values
     */
    public function validDirModeValues()
    {
        $modes   = [];
        $modes[] = [ 777 ];
        $modes[] = [ 510 ];
        $modes[] = [ 0775 ];
        $modes[] = [ 01777 ];
        $modes[] = [ 02777 ];
        $modes[] = [ 04777 ];

        return $modes;
    }

}

?>
