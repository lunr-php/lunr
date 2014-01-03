<?php

/**
 * This file contains the RequestStoreCookieTest class.
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
class RequestStoreCookieTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpEmpty();
    }

    /**
     * Test storing invalid $_COOKIE values.
     *
     * @param mixed $cookie Invalid $_COOKIE values
     *
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\Request::store_cookie
     */
    public function testStoreInvalidCookieValuesLeavesLocalCookieEmpty($cookie)
    {
        $_COOKIE = $cookie;

        $method = $this->get_accessible_reflection_method('store_cookie');
        $method->invoke($this->class);

        $this->assertArrayEmpty($this->get_reflection_property_value('cookie'));
    }

    /**
    * Test storing invalid $_COOKIE values.
    *
    * Checks whether the superglobal $_COOKIE is reset after passing
    * invalid cookie values in it.
    *
    * @param mixed $cookie Invalid $_COOKIE values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_cookie
    */
    public function testStoreInvalidCookieValuesResetsSuperglobalCookie($cookie)
    {
        $_COOKIE = $cookie;

        $method = $this->get_accessible_reflection_method('store_cookie');
        $method->invoke($this->class);

        $this->assertArrayEmpty($_COOKIE);
    }

    /**
     * Test storing valid $_COOKIE values.
     *
     * @covers Lunr\Corona\Request::store_cookie
     */
    public function testStoreValidCookieValues()
    {
        $_COOKIE['test1'] = 'value1';
        $_COOKIE['test2'] = 'value2';
        $cache            = $_COOKIE;

        $method = $this->get_accessible_reflection_method('store_cookie');
        $method->invoke($this->class);

        $this->assertPropertyEquals('cookie', $cache);
    }

    /**
     * Test that $_COOKIE is empty after storing.
     *
     * @covers Lunr\Corona\Request::store_cookie
     */
    public function testSuperglobalCookieEmptyAfterStore()
    {
        $_COOKIE['test1'] = 'value1';
        $_COOKIE['test2'] = 'value2';

        $method = $this->get_accessible_reflection_method('store_cookie');
        $method->invoke($this->class);

        $this->assertArrayEmpty($_COOKIE);
    }

    /**
     * Test that $_COOKIE has only PHPSESSID after storing.
     *
     * @covers Lunr\Corona\Request::store_cookie
     */
    public function testSuperglobalCookieWithPHPSESSIDSet()
    {
        $_COOKIE['test1']     = 'value1';
        $_COOKIE['test2']     = 'value2';
        $_COOKIE['PHPSESSID'] = 'value3';

        $method = $this->get_accessible_reflection_method('store_cookie');
        $method->invoke($this->class);

        $this->assertCount(1, $_COOKIE);
        $this->assertArrayHasKey('PHPSESSID', $_COOKIE);
    }

}

?>
