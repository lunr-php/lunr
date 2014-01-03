<?php

/**
 * This file contains the AuthenticationGetSetTest class.
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
class AuthenticationGetSetTest extends AuthenticationTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpNull();
    }

    /**
     * Test that state is set to a generated string if fetched NULL from the Request class.
     */
    public function testStateIsGeneratedIfRequestedNull()
    {
        $value = $this->get_reflection_property_value('state');

        $this->assertInternaltype('string', $value);
        $this->assertNotEmpty($value);
    }

    /**
     * Test that set_code() sets the code.
     *
     * @covers Lunr\Spark\Facebook\Authentication::set_code
     */
    public function testSetCodeSetsCode()
    {
        $this->class->set_code('New Code');

        $this->assertPropertyEquals('code', 'New Code');
    }

    /**
     * Test that set_redirect_uri() sets the redirect_uri.
     *
     * @covers Lunr\Spark\Facebook\Authentication::set_redirect_uri
     */
    public function testSetRedirectUriSetsUri()
    {
        $this->class->set_redirect_uri('http://example.com');

        $this->assertPropertyEquals('redirect_uri', 'http://example.com');
    }

    /**
     * Test that set_scope() sets the scope.
     *
     * @param mixed  $input    Input value
     * @param String $expected Expected scope string
     *
     * @dataProvider scopeValueProvider
     * @covers       Lunr\Spark\Facebook\Authentication::set_code
     */
    public function testSetScopeSetsScope($input, $expected)
    {
        $this->class->set_scope($input);

        $this->assertPropertyEquals('scope', $expected);
    }

    /**
     * Test that get_state() gets the state.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_state
     */
    public function testGetStateGetsState()
    {
        $this->set_reflection_property_value('state', 'My State');

        $this->assertEquals('My State', $this->class->get_state());
    }

    /**
     * Test that get_code() gets the code.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_code
     */
    public function testGetCodeGetsCode()
    {
        $this->set_reflection_property_value('code', 'My Code');

        $this->assertEquals('My Code', $this->class->get_code());
    }

    /**
     * Test that get_token_expires() gets the token_expires.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_token_expires
     */
    public function testGetTokenExpiresGetsTokenExpires()
    {
        $this->set_reflection_property_value('token_expires', 123);

        $this->assertEquals(123, $this->class->get_token_expires());
    }

    /**
     * Test is_state_verified().
     *
     * @param String  $state State value
     * @param Boolean $valid Whether state is expected valid or not
     *
     * @dataProvider stateValueProvider
     * @covers       Lunr\Spark\Facebook\Authentication::is_state_verified
     */
    public function testIsStateVerified($state, $valid)
    {
        $this->set_reflection_property_value('state', 'valid');

        $this->assertSame($valid, $this->class->is_state_verified($state));
    }

}

?>
