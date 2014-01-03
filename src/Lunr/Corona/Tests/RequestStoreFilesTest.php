<?php

/**
 * This file contains the RequestStoreFilesTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for storing superglobal values.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Dinos Theodorou <dinos@m2mobi.com>
 * @covers        Lunr\Corona\Request
 * @backupGlobals enabled
 */
class RequestStoreFilestTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpEmpty();
    }

    /**
     * Test storing invalid $_FILES values.
     *
     * @param mixed $files Invalid $_FILES values
     *
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\Request::store_files
     */
    public function testStoreInvalidFilesValuesLeavesLocalFilesEmpty($files)
    {
        $_FILES = $files;

        $method = $this->get_accessible_reflection_method('store_files');
        $method->invoke($this->class);

        $this->assertArrayEmpty($this->get_reflection_property_value('files'));
    }

    /**
     * Test storing invalid $_FILES values.
     *
     * Checks whether the superglobal $_FILES is reset to being empty after
     * passing invalid $_FILES values in it.
     *
     * @param mixed $files Invalid $_FILES values
     *
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\Request::store_files
     */
    public function testStoreInvalidFilesValuesResetsSuperglobalFiles($files)
    {
        $_FILES = $files;

        $method = $this->get_accessible_reflection_method('store_files');
        $method->invoke($this->class);

        $this->assertArrayEmpty($_FILES);
    }

    /**
     * Test storing valid $_FILES values.
     *
     * @covers Lunr\Corona\Request::store_files
     */
    public function testStoreValidFilesValues()
    {
        $_FILES['test1'] = [
            'name' => 'Name',
            'type' => 'Type',
            'tmp_name' => 'Tmp',
            'error' => 'Error',
            'size' => 'Size'
        ];

        $_FILES['test2'] = [
            'name' => 'Name2',
            'type' => 'Type2',
            'tmp_name' => 'Tmp2',
            'error' => 'Error2',
            'size' => 'Size2'
        ];

        $cache = $_FILES;

        $method = $this->get_accessible_reflection_method('store_files');
        $method->invoke($this->class);

        $this->assertPropertyEquals('files', $cache);
    }

    /**
     * Test that $_FILES is empty after storing.
     *
     * @covers Lunr\Corona\Request::store_files
     */
    public function testSuperglobalFilesEmptyAfterStore()
    {
        $_FILES['test1'] = [
            'name' => 'Name',
            'type' => 'Type',
            'tmp_name' => 'Tmp',
            'error' => 'Error',
            'size' => 'Size'
        ];

        $_FILES['test2'] = [
            'name' => 'Name2',
            'type' => 'Type2',
            'tmp_name' => 'Tmp2',
            'error' => 'Error2',
            'size' => 'Size2'
        ];

        $method = $this->get_accessible_reflection_method('store_files');
        $method->invoke($this->class);

        $this->assertArrayEmpty($_FILES);
    }

}

?>
