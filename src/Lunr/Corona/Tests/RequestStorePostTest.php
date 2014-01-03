<?php

/**
 * This file contains the RequestStorePostTest class.
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
 * Tests for storing superglobal values.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @author        Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers        Lunr\Corona\Request
 * @backupGlobals enabled
 */
class RequestStorePostTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpEmpty();
    }

    /**
     * Test storing invalid $_POST values.
     *
     * @param mixed $post Invalid $_POST values
     *
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\Request::store_post
     */
    public function testStoreInvalidPostValuesLeavesLocalPostEmpty($post)
    {
        $_POST = $post;

        $method = $this->get_accessible_reflection_method('store_post');
        $method->invoke($this->class);

        $this->assertArrayEmpty($this->get_reflection_property_value('post'));
    }

    /**
    * Test storing invalid $_POST values.
    *
    * Checks whether the superglobal $_POST is reset to being empty after
    * passing invalid $_POST values in it.
    *
    * @param mixed $post Invalid $_POST values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_post
    */
    public function testStoreInvalidPostValuesResetsSuperglobalPost($post)
    {
        $_POST = $post;

        $method = $this->get_accessible_reflection_method('store_post');
        $method->invoke($this->class);

        $this->assertArrayEmpty($_POST);
    }

    /**
     * Test storing valid $_POST values.
     *
     * @covers Lunr\Corona\Request::store_post
     */
    public function testStoreValidPostValues()
    {
        $_POST['test1'] = 'value1';
        $_POST['test2'] = 'value2';
        $cache          = $_POST;

        $method = $this->get_accessible_reflection_method('store_post');
        $method->invoke($this->class);

        $this->assertPropertyEquals('post', $cache);
    }

    /**
     * Test that $_POST is empty after storing.
     *
     * @covers Lunr\Corona\Request::store_post
     */
    public function testSuperglobalPostEmptyAfterStore()
    {
        $_POST['test1'] = 'value1';
        $_POST['test2'] = 'value2';

        $method = $this->get_accessible_reflection_method('store_post');
        $method->invoke($this->class);

        $this->assertArrayEmpty($_POST);
    }

}

?>
