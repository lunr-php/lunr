<?php

/**
 * This file contains the UserBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains the tests for the Facebook User class.
 *
 * @covers Lunr\Spark\Facebook\User
 */
class UserBaseTest extends UserTest
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
     * Test that the Requests_Session class is passed correctly.
     */
    public function testRequestsSessionIsSetCorrectly()
    {
        $this->assertPropertySame('http', $this->http);
    }

    /**
     * Test that the default profile ID is 'me'.
     */
    public function testProfileIDIsMe()
    {
        $this->assertPropertyEquals('profile_id', 'me');
    }

    /**
     * Test that by default permissions is an empty array.
     */
    public function testPermissionsAreEmpty()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

    /**
     * Test that check_permissions is TRUE.
     */
    public function testCheckPermissionsIsTrueByDefault()
    {
        $this->assertTrue($this->get_reflection_property_value('check_permissions'));
    }

    /**
     * Test that set_profile_id() sets the profile ID.
     *
     * @covers Lunr\Spark\Facebook\User::set_profile_id
     */
    public function testSetProfileIdSetsProfileId()
    {
        $this->class->set_profile_id('LunrUser');

        $this->assertPropertyEquals('profile_id', 'LunrUser');
    }

}

?>
