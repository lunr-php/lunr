<?php

/**
 * This file contains the AutoloaderTestPSR4 class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Sean Molenaar   <sean@m2mobi.com>
 * @copyright  2011-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains the tests for the autoloader class' PSR-4 specs.
 *
 * @covers     Lunr\Core\Autoloader
 */
class AutoloaderTestPSR4 extends AutoloaderTest
{

    /**
     * Values to test the PSR-4 Provider with
     * @return array
     */
    public function psr4Provider()
    {
        $classes   = [];
        $classes[] = [ 'L1\L2', 'src/Level/', 'L1\L2\L3\L4\File', 'src/Level/L3/L4/File.php' ];
        $classes[] = [ 'L1\L2', 'src/Level/', 'L1\L2\L4\File', 'src/Level/L4/File.php' ];
        $classes[] = [ 'L1\L2\L4', 'src/Level/', 'L1\L2\L4\File', 'src/Level/File.php' ];
        $classes[] = [ 'L1\L2', 'src/Level/L5/', 'L1\L2\L4\File', 'src/Level/L5/L4/File.php' ];
        $classes[] = [ 'L1\L2', 'src/Level/', 'L1\L2\File', 'src/Level/File.php' ];
        $classes[] = [ 'L1\L2', 'src/Level/', 'L1\File', 'L1/File.php' ];

        $classes[] = [ 'L1\L2', 'src/Level_word/', 'L1\L2\File', 'src/Level_word/File.php' ];
        $classes[] = [ 'L1\L2_word', 'src/Level/', 'L1\L2_word\File', 'src/Level/File.php' ];

        return $classes;
    }

    /**
     * Test loading of prefixes according to PSR-4 specifics.
     *
     * @param string $partialClass The partial hierarchy for the class
     * @param string $partialPath  The path to the partial class hierarchy
     *
     * @dataProvider psr4Provider
     *
     * @covers Lunr\Core\Autoloader::set_prefix
     */
    public function testLoadPrefixesForPSR4($partialClass, $partialPath)
    {
        $this->autoloader->set_prefix($partialClass, $partialPath);

        $prefixes = $this->autoloader_reflection->getProperty('prefixes');
        $prefixes->setAccessible(TRUE);

        $this->assertContains($partialPath, $prefixes->getValue($this->autoloader));
    }

    /**
     * Test loading of classes according to PSR-4 specifics.
     *
     * @param string $partialClass The partial hierarchy for the class
     * @param string $partialPath  The path to the partial class hierarchy
     * @param string $fullClass    The full class to load
     * @param string $fullPath     The full path to the class file
     *
     * @dataProvider psr4Provider
     *
     * @covers Lunr\Core\Autoloader::get_psr4_class_filepath
     */
    public function testLoadOfPSR4ClassesFromPrefixes($partialClass, $partialPath, $fullClass, $fullPath)
    {
        $this->autoloader->set_prefix($partialClass, $partialPath);
        $this->assertEquals($fullPath, $this->autoloader->get_psr4_class_filepath($fullClass));
    }

    /**
     * Test loading of classes according to PSR-4 specifics.
     *
     * @dataProvider psr4Provider
     *
     * @covers Lunr\Core\Autoloader::load
     */
    public function testLoadOfPSR4Classes()
    {
        $this->autoloader->set_prefix('PSR4', TEST_STATICS . '/Core/');

        $filename = TEST_STATICS . '/Core/PSR4TestFile.php';
        $class    = 'PSR4\PSR4TestFile';

        $this->autoloader->load($class);

        $this->assertContains($filename, get_included_files());
    }

    /**
     * Test colliding of classes according to PSR-4 specifics.
     *
     * First runs the testLoadOfPSR4Classes() test and then loads the exact same
     * file from a different prefix to see if it can distinguish between the two.
     *
     * @depends testLoadOfPSR4Classes
     * @covers Lunr\Core\Autoloader::load
     */
    public function testLoadOfCollidingPSR4Classes()
    {
        $this->autoloader->set_prefix('PSR4Test', TEST_STATICS . '/Core/PSR-4/');

        $filename_test = TEST_STATICS . '/Core/PSR-4/PSR4TestFile.php';
        $class_test    = 'PSR4Test\PSR4TestFile';

        $this->assertNotContains($filename_test, get_included_files());

        $this->autoloader->load($class_test);

        $this->assertContains($filename_test, get_included_files());
    }

}

?>
