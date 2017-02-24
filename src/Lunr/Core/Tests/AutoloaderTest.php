<?php

/**
 * This file contains the AutoloaderTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\Autoloader;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * This class contains the tests for the autoloader class.
 *
 * @covers     Lunr\Core\Autoloader
 */
class AutoloaderTest extends TestCase
{

    /**
     * Instance of the Autoloader class
     * @var Autoloader
     */
    protected $autoloader;

    /**
     * Reflection Instance of the Autoloader class
     * @var ReflectionClass
     */
    protected $autoloader_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->autoloader            = new Autoloader();
        $this->autoloader_reflection = new ReflectionClass('Lunr\Core\Autoloader');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->autoloader);
        unset($this->autoloader_reflection);
    }

    /**
     * Test the default values for the controller array.
     */
    public function testDefaultControllers()
    {
        $controllers = $this->autoloader_reflection->getProperty('controllers');
        $controllers->setAccessible(TRUE);

        $value = $controllers->getValue($this->autoloader);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test the static function add_include_path().
     *
     * @covers Lunr\Core\Autoloader::add_include_path
     */
    public function testAddIncludePath()
    {
        $path_before = get_include_path();
        $this->autoloader->add_include_path('LunrUnitTestString');
        $path_after = get_include_path();
        $this->assertEquals($path_before . ':LunrUnitTestString', $path_after);
    }

    /**
     * Test registering the autoloader class.
     *
     * @covers Lunr\Core\Autoloader::register
     */
    public function testRegisterAutoloader()
    {
        $this->assertEquals(1, $this->check_spl_autoload_stack(spl_autoload_functions()));

        $value = $this->autoloader->register();

        $this->assertTrue($value);
        $this->assertEquals(2, $this->check_spl_autoload_stack(spl_autoload_functions()));

        $this->autoloader->unregister();
    }

    /**
     * Test unregistering the autoloader class.
     *
     * @depends testRegisterAutoloader
     * @covers  Lunr\Core\Autoloader::unregister
     */
    public function testUnregisterAutoloader()
    {
        $this->assertEquals(1, $this->check_spl_autoload_stack(spl_autoload_functions()));

        $value = $this->autoloader->register();

        $this->assertTrue($value);

        $this->assertEquals(2, $this->check_spl_autoload_stack(spl_autoload_functions()));

        $value = $this->autoloader->unregister();

        $this->assertTrue($value);

        $this->assertEquals(1, $this->check_spl_autoload_stack(spl_autoload_functions()));
    }

    /**
     * Unit Test Data Provider for Abstract Controller names.
     *
     * @return array $controllers Array of Controller basenames
     */
    public function controllerProvider()
    {
        $controllers   = [];
        $controllers[] = ['lunr', 'lunr'];
        $controllers[] = ['Lunr2', 'lunr2'];

        return $controllers;
    }

    /**
     * Check how often the Lunr autoloader is on the spl autoload stack.
     *
     * @param array $stack Autoloader stack
     *
     * @return Integer $contains Number of instances of the Lunr autloader on the stack.
     */
    public function check_spl_autoload_stack($stack)
    {
        $contains = 0;
        foreach ($stack as $value)
        {
            if (!is_array($value))
            {
                continue;
            }

            if ($value[0] === $this->autoloader);
            {
                $contains += 1;
            }
        }

        return $contains;
    }

}

?>
