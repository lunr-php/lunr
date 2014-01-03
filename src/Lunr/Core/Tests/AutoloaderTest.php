<?php

/**
 * This file contains the AutoloaderTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\Autoloader;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains the tests for the autoloader class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\Autoloader
 */
class AutoloaderTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Autoloader class
     * @var Autoloader
     */
    private $autoloader;

    /**
     * Reflection Instance of the Autoloader class
     * @var ReflectionClass
     */
    private $autoloader_reflection;

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
     * Test the function get_legacy_class_filename().
     *
     * @param String $class    classname (not namespaced)
     * @param String $filename name of the file that contains the class
     *
     * @dataProvider normalClassProvider
     * @covers       Lunr\Core\Autoloader::get_legacy_class_filename
     */
    public function testGetLegacyClassFileName($class, $filename)
    {
        $method = $this->autoloader_reflection->getMethod('get_legacy_class_filename');
        $method->setAccessible(TRUE);

        $this->assertEquals($filename, $method->invokeArgs($this->autoloader, array($class)));
    }

    /**
     * Test that get_file_path() returns filepaths according to PSR-0.
     *
     * @param String $class    classname (not namespaced)
     * @param String $filename name of the file that contains the class
     *
     * @dataProvider psr0Provider
     * @covers       Lunr\Core\Autoloader::get_class_filepath
     */
    public function testGetFilePath($class, $filename)
    {
        $method = $this->autoloader_reflection->getMethod('get_class_filepath');
        $method->setAccessible(TRUE);

        $this->assertEquals($filename, $method->invokeArgs($this->autoloader, array($class)));
    }

    /**
     * Test the static function register_project_controller().
     *
     * @param String $input    Controller Name
     * @param String $expected Normalized Controller Name
     *
     * @dataProvider controllerProvider
     * @covers       Lunr\Core\Autoloader::register_project_controller
     */
    public function testRegisterProjectController($input, $expected)
    {
        $controllers = $this->autoloader_reflection->getProperty('controllers');
        $controllers->setAccessible(TRUE);

        $controllers_base = $controllers->getValue($this->autoloader);

        $this->assertNotContains($expected, $controllers_base);

        $this->autoloader->register_project_controller($input);

        $controllers_after = $controllers->getValue($this->autoloader);

        $this->assertContains($expected, $controllers_after);
    }

    /**
     * Test the function get_legacy_class_filename() with registered project controllers.
     *
     * @param String $basename   Base Controller name (with 'Controller')
     * @param String $normalized Normalied Controller name (lowercase)
     *
     * @depends      testRegisterProjectController
     * @dataProvider controllerProvider
     * @covers       Lunr\Core\Autoloader::get_legacy_class_filename
     */
    public function testGetLegacyClassFileNameForRegisteredProjectController($basename, $normalized)
    {
        $class    = $basename . 'Controller';
        $filename = 'class.' . $normalized . 'controller.inc.php';
        $this->autoloader->register_project_controller($basename);
        $method = $this->autoloader_reflection->getMethod('get_legacy_class_filename');
        $method->setAccessible(TRUE);
        $this->assertEquals($filename, $method->invokeArgs($this->autoloader, array($class)));
    }

    /**
     * Test the function get_legacy_class_filepath().
     *
     * @param String $class    namespaced classname
     * @param String $filepath exptected filepath
     *
     * @depends      testGetLegacyClassFileName
     * @dataProvider namespacedClassProvider
     * @covers       Lunr\Core\Autoloader::get_legacy_class_filepath
     */
    public function testGetLegacyClassFilePath($class, $filepath)
    {
        $method = $this->autoloader_reflection->getMethod('get_legacy_class_filepath');
        $method->setAccessible(TRUE);
        $this->assertEquals($filepath, $method->invokeArgs($this->autoloader, array($class)));
    }

    /**
     * Test loading of classes according to Lunr-0.1 specifics.
     *
     * @covers Lunr\Core\Autoloader::load
     */
    public function testLoadOfLunr01Classes()
    {
        $filename = 'libraries/core/class.lunr01testfile.inc.php';
        $class    = 'Lunr\Libraries\Core\Lunr01TestFile';

        $basename = str_replace('src/Lunr/Core/Tests', 'system/', dirname(__FILE__));
        $filename = $basename . $filename;

        $this->assertNotContains($filename, get_included_files());
        $this->autoloader->load($class);
        $this->assertContains($filename, get_included_files());
    }

    /**
     * Test loading of classes according to PSR-0 specifics.
     *
     * @covers Lunr\Core\Autoloader::load
     */
    public function testLoadOfPSR0Classes()
    {
        $filename = 'PSR0TestFile.php';
        $class    = 'Lunr\Core\Tests\PSR0TestFile';

        $basename = dirname(__FILE__) . '/';
        $filename = $basename . $filename;

        $this->assertNotContains($filename, get_included_files());
        $this->autoloader->load($class);
        $this->assertContains($filename, get_included_files());
    }

    /**
     * Unit Test Data Provider for Abstract Controller names.
     *
     * @return array $controllers Array of Controller basenames
     */
    public function controllerProvider()
    {
        $controllers   = array();
        $controllers[] = array('lunr', 'lunr');
        $controllers[] = array('Lunr2', 'lunr2');

        return $controllers;
    }

    /**
     * Unit Test Data Provider for unnamespaced classnames.
     *
     * @return array $classes Array of Classnames and their expected filenames
     */
    public function normalClassProvider()
    {
        $classes   = array();
        $classes[] = array('DateTime', 'class.datetime.inc.php');
        $classes[] = array('StubView', 'view.stub.inc.php');
        $classes[] = array('JsonInterface', 'interface.json.inc.php');
        $classes[] = array('StubModel', 'model.stub.inc.php');
        $classes[] = array('StubController', 'controller.stub.inc.php');
        $classes[] = array('MockView', 'class.view.mock.php');
        $classes[] = array('DateTimeTest', 'class.datetime.test.php');
        $classes[] = array('View', 'class.view.inc.php');

        return $classes;
    }

    /**
     * Unit Test Data Provider for namespaced classnames.
     *
     * @return array $classes Array of Classnames and their expected filepaths
     */
    public function namespacedClassProvider()
    {
        $classes   = array();
        $classes[] = array('Lunr\Libraries\Core\Lunr01TestFile', 'libraries/core/class.lunr01testfile.inc.php');

        return $classes;
    }

    /**
     * Unit Test Data Provider for PSR-0 compliant classnames.
     *
     * @return array $classes Array of classes and their expected filenames.
     */
    public function psr0Provider()
    {
        $classes   = array();
        $classes[] = array('\Doctrine\Common\IsolatedClassLoader', 'Doctrine/Common/IsolatedClassLoader.php');
        $classes[] = array('\Symfony\Core\Request', 'Symfony/Core/Request.php');
        $classes[] = array('\Zend\Acl', 'Zend/Acl.php');
        $classes[] = array('\Zend\Mail\Message', 'Zend/Mail/Message.php');
        $classes[] = array('\namespace\package\Class_Name', 'namespace/package/Class/Name.php');
        $classes[] = array('\namespace\package_name\Class_Name', 'namespace/package_name/Class/Name.php');
        $classes[] = array('Lunr\Core\Tests\PSR0TestFile', 'Lunr/Core/Tests/PSR0TestFile.php');
        $classes[] = array('Resque', 'Resque.php');

        return $classes;
    }

    /**
     * Unit Test Data Provider for filenames.
     *
     * @return array $files Array of Classnames and their expected filepaths relative to the project root
     */
    public function fileProvider()
    {
        $files   = array();
        $files[] = array('Lunr\Core\Lunr01TestFile', 'system/libraries/core/class.lunr01testfile.inc.php');

        return $files;
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
