<?php

/**
 * This file contains the UserBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\User;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook User class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\User
 */
class UserBaseTest extends UserTest
{

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
     * Test that the Logger class is passed correctly.
     */
    public function testLoggerIsSetCorrectly()
    {
        $this->assertPropertySame('logger', $this->logger);
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
