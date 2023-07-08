<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray\Tests;

use Lunr\Ray\PhysicalFilesystemAccessObject;
use Psr\Log\LoggerInterface;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use stdClass;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the PhysicalFilesystemAccessObject class.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
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
     * @var string
     */
    protected $find_location;

    /**
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->logger        = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $this->class         = new PhysicalFilesystemAccessObject($this->logger);
        $this->reflection    = new ReflectionClass('Lunr\Ray\PhysicalFilesystemAccessObject');
        $this->find_location = TEST_STATICS . '/Ray';
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->logger);
        unset($this->find_location);
    }

    /**
     * Unit test data provider for boolean file or directory names.
     *
     * @return array $names Array of boolean names,
     */
    public function booleanNameProvider(): array
    {
        $names   = [];
        $names[] = [ FALSE ];

        return $names;
    }

    /**
     * Unit test data provider for invalid file open modes.
     *
     * @return array $modes Array of invalid modes,
     */
    public function invalidModesProvider(): array
    {
        $modes   = [];
        $modes[] = [ TRUE, ': failed to open stream: No such file or directory' ];
        $modes[] = [ FALSE, ': failed to open stream: No such file or directory' ];

        return $modes;
    }

    /**
     * Unit test data provider for empty filepath values.
     *
     * @return array $filepath Array of invalid filepaths
     */
    public function emptyFilepathValueProvider(): array
    {
        $filepath   = [];
        $filepath[] = [ FALSE ];

        return $filepath;
    }

    /**
     * Unit test data provider for invalid filepath values.
     *
     * @return array $filepath Array of invalid filepaths
     */
    public function invalidFilepathValueProvider(): array
    {
        $filepath = [];

        if (PHP_VERSION_ID >= 80000)
        {
            $filepath[] = [
                '/tmp56474q',
                'RecursiveDirectoryIterator::__construct(/tmp56474q): Failed to open directory: No such file or directory',
            ];
            $filepath[] = [
                '/root',
                'RecursiveDirectoryIterator::__construct(/root): Failed to open directory: Permission denied',
            ];
        }
        else
        {
            $filepath[] = [
                '/tmp56474q',
                'RecursiveDirectoryIterator::__construct(/tmp56474q): failed to open dir: No such file or directory',
            ];
            $filepath[] = [
                '/root',
                'RecursiveDirectoryIterator::__construct(/root): failed to open dir: Permission denied',
            ];
        }

        return $filepath;
    }

    /**
     * Unit test data provider for invalid array values.
     *
     * @return array $values Array of invalid values
     */
    public function invalidCSVArrayValuesProvider(): array
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
    public function invalidDirModeValuesProvider(): array
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
    public function validDirModeValuesProvider(): array
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
