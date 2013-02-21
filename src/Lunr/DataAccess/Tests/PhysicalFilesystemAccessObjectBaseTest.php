<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectBaseTest class.
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

/**
 * This class contains base tests for the PhysicalFilesystemAccessObject.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectBaseTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that the logger class is passed correctly.
     */
    public function testLoggerIsPassedCorrectly()
    {
        $property = $this->reflection->getProperty('logger');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInstanceOf('Psr\Log\LoggerInterface', $value);
        $this->assertSame($this->logger, $value);
    }

}

?>
