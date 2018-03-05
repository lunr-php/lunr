<?php

/**
 * This file contains the AutoloaderTestLegacy class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains the tests for the autoloader class' legacy specs.
 *
 * @covers     Lunr\Core\Autoloader
 */
class AutoloaderTestLegacy extends AutoloaderTest
{

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

        $this->assertEquals($filename, $method->invokeArgs($this->autoloader, [$class]));
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
        $this->assertEquals($filename, $method->invokeArgs($this->autoloader, [$class]));
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
        $this->assertEquals($filepath, $method->invokeArgs($this->autoloader, [$class]));
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
     * Unit Test Data Provider for unnamespaced classnames.
     *
     * @return array $classes Array of Classnames and their expected filenames
     */
    public function normalClassProvider()
    {
        $classes   = [];
        $classes[] = ['DateTime', 'class.datetime.inc.php'];
        $classes[] = ['StubView', 'view.stub.inc.php'];
        $classes[] = ['JsonInterface', 'interface.json.inc.php'];
        $classes[] = ['StubModel', 'model.stub.inc.php'];
        $classes[] = ['StubController', 'controller.stub.inc.php'];
        $classes[] = ['MockView', 'class.view.mock.php'];
        $classes[] = ['DateTimeTest', 'class.datetime.test.php'];
        $classes[] = ['View', 'class.view.inc.php'];

        return $classes;
    }

    /**
     * Unit Test Data Provider for namespaced classnames.
     *
     * @return array $classes Array of Classnames and their expected filepaths
     */
    public function namespacedClassProvider()
    {
        $classes   = [];
        $classes[] = ['Lunr\Libraries\Core\Lunr01TestFile', 'libraries/core/class.lunr01testfile.inc.php'];

        return $classes;
    }

    /**
     * Unit Test Data Provider for filenames.
     *
     * @return array $files Array of Classnames and their expected filepaths relative to the project root
     */
    public function fileProvider()
    {
        $files   = [];
        $files[] = ['Lunr\Core\Lunr01TestFile', 'system/libraries/core/class.lunr01testfile.inc.php'];

        return $files;
    }

}

?>
