<?php

/**
 * This file contains the UserProfileBaseTest class.
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

use Lunr\Spark\Facebook\UserProfile;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook UserProfile class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\UserProfile
 */
class UserProfileBaseTest extends UserProfileTest
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
     * Test that data is empty.
     */
    public function testDataIsEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that used_access_token is FALSE.
     */
    public function testUsedAccessTokenIsFalseByDefault()
    {
        $this->assertFalse($this->get_reflection_property_value('used_access_token'));
    }

}

?>
