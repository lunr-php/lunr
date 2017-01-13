<?php

/**
 * This file contains the AutoloaderTestPSR0 class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains the tests for the autoloader class' PSR-0 specs.
 *
 * @covers     Lunr\Core\Autoloader
 */
class AutoloaderTestPSR0 extends AutoloaderTest
{

    /**
     * Test that get_file_path() returns filepaths according to PSR-0.
     *
     * @param String $class    classname (not namespaced)
     * @param String $filename name of the file that contains the class
     *
     * @dataProvider psr0Provider
     * @covers       Lunr\Core\Autoloader::get_psr0_class_filepath
     */
    public function testGetFilePath($class, $filename)
    {
        $method = $this->autoloader_reflection->getMethod('get_psr0_class_filepath');
        $method->setAccessible(TRUE);

        $this->assertEquals($filename, $method->invokeArgs($this->autoloader, [$class]));
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
     * Unit Test Data Provider for PSR-0 compliant classnames.
     *
     * @return array $classes Array of classes and their expected filenames.
     */
    public function psr0Provider()
    {
        $classes   = [];
        $classes[] = ['\Doctrine\Common\IsolatedClassLoader', 'Doctrine/Common/IsolatedClassLoader.php'];
        $classes[] = ['\Symfony\Core\Request', 'Symfony/Core/Request.php'];
        $classes[] = ['\Zend\Acl', 'Zend/Acl.php'];
        $classes[] = ['\Zend\Mail\Message', 'Zend/Mail/Message.php'];
        $classes[] = ['\namespace\package\Class_Name', 'namespace/package/Class/Name.php'];
        $classes[] = ['\namespace\package_name\Class_Name', 'namespace/package_name/Class/Name.php'];
        $classes[] = ['Lunr\Core\Tests\PSR0TestFile', 'Lunr/Core/Tests/PSR0TestFile.php'];
        $classes[] = ['Resque', 'Resque.php'];

        return $classes;
    }

}

?>
