<?php

/**
 * This file contains the RequestGetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for getting stored superglobal values.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @author        Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers        Lunr\Corona\Request
 * @backupGlobals enabled
 */
class RequestGetTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpFilled();
    }

    /**
     * Check that request values are returned correctly by the magic get method.
     *
     * @param String $key   key for a request value
     * @param mixed  $value value of a request value
     *
     * @dataProvider properRequestValueProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetMethod($key, $value)
    {
        $this->assertEquals($value, $this->class->$key);
    }

    /**
     * Test getting GET data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Corona\Request::get_get_data
     */
    public function testGetGetData($value, $key)
    {
        $this->assertEquals($value, $this->class->get_get_data($key));
    }

    /**
     * Test getting POST data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Corona\Request::get_post_data
     */
    public function testGetPostData($value, $key)
    {
        $this->assertEquals($value, $this->class->get_post_data($key));
    }

    /**
     * Test getting FILES data.
     *
     * @covers Lunr\Corona\Request::get_files_data
     */
    public function testGetFileData()
    {
        $value = [
            'image' => [
                'name' => 'Name',
                'type' => 'Type',
                'tmp_name' => 'Tmp',
                'error' => 'Error',
                'size' => 'Size'
            ]
        ];

        $this->assertEquals($value['image'], $this->class->get_files_data('image'));
    }

    /**
     * Test getting GET data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Corona\Request::get_cookie_data
     */
    public function testGetCookieData($value, $key)
    {
        $this->assertEquals($value, $this->class->get_cookie_data($key));
    }

    /**
     * Tests that get_new_inter_request_object returns an InterRequest object.
     *
     * @covers Lunr\Corona\Request::get_new_inter_request_object
     */
    public function testGetNewInterRequestObject()
    {
        $value = $this->class->get_new_inter_request_object(array());

        $this->assertInstanceOf('Lunr\Corona\InterRequest', $value);
    }

}

?>
