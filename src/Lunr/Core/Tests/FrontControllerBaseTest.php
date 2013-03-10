<?php

/**
 * This file contains the FrontControllerBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\FrontController;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains base tests for the FrontController class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\FrontController
 */
class FrontControllerBaseTest extends FrontControllerTest
{

    /**
     * Test that the Request class was passed correctly.
     */
    public function testRequestPassedCorrectly()
    {
        $property = $this->reflection->getProperty('request');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInstanceOf('Lunr\Core\Request', $value);
        $this->assertSame($this->request, $value);
    }

    /**
     * Test that the Response class was passed correctly.
     */
    public function testResponsePassedCorrectly()
    {
        $property = $this->reflection->getProperty('response');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInstanceOf('Lunr\Core\Response', $value);
        $this->assertSame($this->response, $value);
    }

    /**
     * Test that the FilesystemAccessObject class was passed correctly.
     */
    public function testFAOPassedCorrectly()
    {
        $property = $this->reflection->getProperty('fao');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInstanceOf('Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface', $value);
        $this->assertSame($this->fao, $value);
    }

    /**
     * Test that there are no error enums set by default.
     */
    public function testErrorEmptyByDefault()
    {
        $property = $this->reflection->getProperty('error');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

}

?>
