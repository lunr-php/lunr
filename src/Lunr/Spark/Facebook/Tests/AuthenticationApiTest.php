<?php

/**
 * This file contains the AuthenticationApiTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Authentication;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Authentication.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Authentication
 */
class AuthenticationApiTest extends AuthenticationTest
{

    /**
     * Test get_login_url() without specifying scope.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_login_url
     */
    public function testGetLoginUrlWithoutScope()
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->set_reflection_property_value('state', 'State');

        $url = 'https://www.facebook.com/dialog/oauth?client_id=Lunr&redirect_uri=http%3A%2F%2Flocalhost%2Fcontroller%2Fmethod%2F&state=State';

        $this->assertEquals($url, $this->class->get_login_url());
    }

    /**
     * Test get_login_url() with specifying scope.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_login_url
     */
    public function testGetLoginUrlWithScope()
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->set_reflection_property_value('state', 'State');
        $this->set_reflection_property_value('scope', 'email');

        $url    = 'https://www.facebook.com/dialog/oauth?';
        $params = 'client_id=Lunr&redirect_uri=http%3A%2F%2Flocalhost%2Fcontroller%2Fmethod%2F&state=State&scope=email';

        $this->assertEquals($url . $params, $this->class->get_login_url());
    }

    /**
     * Test get_logout_url().
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_logout_url
     */
    public function testGetLogoutUrl()
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $url    = 'https://www.facebook.com/logout.php?';
        $params = 'next=http%3A%2F%2Flocalhost%2Fcontroller%2Fmethod%2F&access_token=Token';

        $this->assertEquals($url . $params, $this->class->get_logout_url());
    }

}

?>
