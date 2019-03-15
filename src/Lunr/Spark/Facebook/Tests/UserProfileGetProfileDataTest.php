<?php

/**
 * This file contains the UserProfileGetProfileDataTest class.
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\UserProfile;
use Lunr\Spark\DataError;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook UserProfile class.
 *
 * @covers Lunr\Spark\Facebook\UserProfile
 */
class UserProfileGetProfileDataTest extends UserProfileTest
{

    /**
     * Test that getting profile data return NOT_REQUESTED when using fields and requested field was not requested.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetProfileDataReturnsNotRequestedWhenUsingFields(): void
    {
        $this->set_reflection_property_value('fields', [ 'foo' ]);

        $this->assertSame(DataError::NOT_REQUESTED, $this->class->get_bar());
    }

    /**
     * Test that getting public profile data returns the data if it is present.
     *
     * @param string $field Field name
     *
     * @dataProvider publicFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetPublicProfileDataReturnsDataIfPresent($field): void
    {
        $this->set_reflection_property_value('data', [ $field => 'Value' ]);

        $this->assertEquals('Value', $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting public profile data returns NOT_AVAILABLE if it is not present.
     *
     * @param string $field Field name
     *
     * @dataProvider publicFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetPublicProfileDataReturnsNotAvailableIfNotPresent($field): void
    {
        $this->assertSame(DataError::NOT_AVAILABLE, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting profile data requiring an access token returns the data if it is present.
     *
     * @param string $field Field name
     *
     * @dataProvider accessTokenFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetAccessTokenProfileDataReturnsDataIfPresent($field): void
    {
        $this->set_reflection_property_value('used_access_token', TRUE);
        $this->set_reflection_property_value('data', [ $field => 'Value' ]);

        $this->assertEquals('Value', $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting profile data requiring an access token returns NOT_AVAILABLE if it is not present.
     *
     * @param string $field Field name
     *
     * @dataProvider accessTokenFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetAccessTokenProfileDataReturnsNotAvailableIfNotPresent($field): void
    {
        $this->set_reflection_property_value('used_access_token', TRUE);

        $this->assertSame(DataError::NOT_AVAILABLE, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting profile data requiring an access token returns ACCESS_DENIED if no access token was used for the request.
     *
     * @param string $field Field name
     *
     * @dataProvider accessTokenFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetAccessTokenProfileDataReturnsAccessDeniedIfNoAccessTokenUsed($field): void
    {
        $message = 'Access to "{field}" requires an access token.';
        $context = [ 'field' => $field ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $this->assertSame(DataError::ACCESS_DENIED, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting profile data requiring permissions returns the data if it is present.
     *
     * @param string $field      Field name
     * @param string $permission Required permission
     *
     * @dataProvider permissionFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetPermissionProfileDataReturnsDataIfPresent($field, $permission): void
    {
        $this->set_reflection_property_value('permissions', [ $permission => 1 ]);
        $this->set_reflection_property_value('data', [ $field => 'Value' ]);

        $this->assertEquals('Value', $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting profile data requiring permissions returns NOT_AVAILABLE if it is not present.
     *
     * @param string $field      Field name
     * @param string $permission Required permission
     *
     * @dataProvider permissionFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetPermissionProfileDataReturnsNotAvailableIfNotPresent($field, $permission): void
    {
        $this->set_reflection_property_value('permissions', [ $permission => 1 ]);

        $this->assertSame(DataError::NOT_AVAILABLE, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting profile data requiring permissions returns ACCESS_DENIED if permission is missing.
     *
     * @param string $field      Field name
     * @param string $permission Required permission
     *
     * @dataProvider permissionFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetPermissionProfileDataReturnsAccessDeniedIfPermissionMissing($field, $permission): void
    {
        $message = 'Access to "{field}" requires "{permission}" permission.';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message));

        $this->assertSame(DataError::ACCESS_DENIED, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting profile data specifically requested returns the data if it is present.
     *
     * @param string $field Field name
     *
     * @dataProvider requestedFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetRequestedProfileDataReturnsDataIfPresent($field): void
    {
        $this->set_reflection_property_value('fields', [ $field ]);
        $this->set_reflection_property_value('data', [ $field => 'Value' ]);

        $this->assertEquals('Value', $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting profile data specifically requested returns NOT_AVAILABLE if it is not present.
     *
     * @param string $field Field name
     *
     * @dataProvider requestedFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetRequestedProfileDataReturnsNotAvailableIfNotPresent($field): void
    {
        $this->set_reflection_property_value('fields', [ $field ]);

        $this->assertSame(DataError::NOT_AVAILABLE, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting profile data specifically requested returns NOT_REQUESTED if it was not requested.
     *
     * @param string $field Field name
     *
     * @dataProvider requestedFieldsProvider
     * @covers       Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetRequestedProfileDataReturnsNotRequestedIfNotRequested($field): void
    {
        $message = 'Access to "{field}" needs to be requested specifically.';
        $context = [ 'field' => $field ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $this->assertSame(DataError::NOT_REQUESTED, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting security settings returns ACCESS_DENIED when data not requested from current user.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetSecuritySettingsReturnsAccessDeniedIfRequestingForADifferentUser(): void
    {
        $this->set_reflection_property_value('profile_id', 'random_user');

        $message = 'Access to "{field}" only allowed for current user.';
        $context = [ 'field' => 'security_settings' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $this->assertSame(DataError::ACCESS_DENIED, $this->class->get_security_settings());
    }

    /**
     * Test that getting unknown profile data returns UNKNOWN_FIELD.
     *
     * @covers Lunr\Spark\Facebook\UserProfile::__call
     */
    public function testGetProfileDataReturnsUnknownFieldForUnknownFields(): void
    {
        $this->assertSame(DataError::UNKNOWN_FIELD, $this->class->get_unknown_field());
    }

}

?>
