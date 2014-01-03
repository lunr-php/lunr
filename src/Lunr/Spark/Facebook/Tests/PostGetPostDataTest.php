<?php

/**
 * This file contains the PostGetPostDataTest class.
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

use Lunr\Spark\DataError;

/**
 * This class contains the tests for the Facebook Post class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Post
 */
class PostGetPostDataTest extends PostTest
{

    /**
     * Test that getting post data return NOT_REQUESTED when using fields and requested field was not requested.
     *
     * @covers Lunr\Spark\Facebook\Post::__call
     */
    public function testGetPostDataReturnsNotRequestedWhenUsingFields()
    {
        $this->set_reflection_property_value('fields', [ 'foo' ]);

        $this->assertSame(DataError::NOT_REQUESTED, $this->class->get_bar());
    }

    /**
     * Test that getting post data requiring an access token returns the data if it is present.
     *
     * @param String $field Field name
     *
     * @dataProvider accessTokenFieldsProvider
     * @covers       Lunr\Spark\Facebook\Post::__call
     */
    public function testGetAccessTokenPostDataReturnsDataIfPresent($field)
    {
        $this->set_reflection_property_value('used_access_token', TRUE);
        $this->set_reflection_property_value('data', [ $field => 'Value' ]);

        $this->assertEquals('Value', $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting post data requiring an access token returns NOT_AVAILABLE if it is not present.
     *
     * @param String $field Field name
     *
     * @dataProvider accessTokenFieldsProvider
     * @covers       Lunr\Spark\Facebook\Post::__call
     */
    public function testGetAccessTokenPostDataReturnsNotAvailableIfNotPresent($field)
    {
        $this->set_reflection_property_value('used_access_token', TRUE);

        $this->assertSame(DataError::NOT_AVAILABLE, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting post data requiring an access token returns ACCESS_DENIED if no access token was used for the request.
     *
     * @param String $field Field name
     *
     * @dataProvider accessTokenFieldsProvider
     * @covers       Lunr\Spark\Facebook\Post::__call
     */
    public function testGetAccessTokenPostDataReturnsAccessDeniedIfNoAccessTokenUsed($field)
    {
        $message = 'Access to "{field}" requires an access token.';
        $context = [ 'field' => $field ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $this->assertSame(DataError::ACCESS_DENIED, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting post data requiring permissions returns the data if it is present.
     *
     * @param String $field      Field name
     * @param String $permission Required permission
     *
     * @dataProvider permissionFieldsProvider
     * @covers       Lunr\Spark\Facebook\Post::__call
     */
    public function testGetPermissionPostDataReturnsDataIfPresent($field, $permission)
    {
        $this->set_reflection_property_value('permissions', [ $permission => 1 ]);
        $this->set_reflection_property_value('data', [ $field => 'Value' ]);

        $this->assertEquals('Value', $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting post data requiring permissions returns NOT_AVAILABLE if it is not present.
     *
     * @param String $field      Field name
     * @param String $permission Required permission
     *
     * @dataProvider permissionFieldsProvider
     * @covers       Lunr\Spark\Facebook\Post::__call
     */
    public function testGetPermissionPostDataReturnsNotAvailableIfNotPresent($field, $permission)
    {
        $this->set_reflection_property_value('permissions', [ $permission => 1 ]);

        $this->assertSame(DataError::NOT_AVAILABLE, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting post data requiring permissions returns ACCESS_DENIED if permission is missing.
     *
     * @param String $field      Field name
     * @param String $permission Required permission
     *
     * @dataProvider permissionFieldsProvider
     * @covers       Lunr\Spark\Facebook\Post::__call
     */
    public function testGetPermissionPostDataReturnsAccessDeniedIfPermissionMissing($field, $permission)
    {
        $message = 'Access to "{field}" requires "{permission}" permission.';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message));

        $this->assertSame(DataError::ACCESS_DENIED, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting unknown post data returns UNKNOWN_FIELD.
     *
     * @covers Lunr\Spark\Facebook\Post::__call
     */
    public function testGetPostDataReturnsUnknownFieldForUnknownFields()
    {
        $this->assertSame(DataError::UNKNOWN_FIELD, $this->class->get_unknown_field());
    }

}

?>
