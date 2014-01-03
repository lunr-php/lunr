<?php

/**
 * This file contains the AuthenticationBaseTest class.
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

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains the tests for the Authentication.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Authentication
 */
class AuthenticationBaseTest extends AuthenticationTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the CentralAuthenticationStore class is passed correctly.
     */
    public function testCasIsSetCorrectly()
    {
        $this->assertPropertySame('cas', $this->cas);
    }

    /**
     * Test that the Curl class is passed correctly.
     */
    public function testCurlIsSetCorrectly()
    {
        $this->assertPropertySame('curl', $this->curl);
    }

    /**
     * Test that state is fetched from the Request class.
     */
    public function testStateIsFetchedFromRequest()
    {
        $this->assertPropertyEquals('state', 'String');
    }

    /**
     * Test that code is fetched from the Request class.
     */
    public function testCodeIsFetchedFromRequest()
    {
        $this->assertPropertyEquals('code', 'String');
    }

    /**
     * Test that the default redirect URI is set from Request class values.
     */
    public function testRedirectUriIsSetFromRequest()
    {
        $this->assertPropertyEquals('redirect_uri', 'http://localhost/controller/method/');
    }

    /**
     * Test that scope is NULL.
     */
    public function testScopeIsNull()
    {
        $this->assertNull($this->get_reflection_property_value('scope'));
    }

    /**
     * Test that token_expires is 0.
     */
    public function testTokenExpiresIsZero()
    {
        $this->assertPropertySame('token_expires', 0);
    }

}

?>
