<?php

/**
 * This file contains the FeedClassifyTest class.
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

use ReflectionClass;

/**
 * This class contains the tests for the Facebook Feed class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Feed
 */
class FeedClassifyTest extends FeedTest
{

    /**
     * Test that classify() resets the request information if the returned value does not contain a 'data' key.
     *
     * @covers Lunr\Spark\Facebook\Feed::classify
     */
    public function testClassifyResetsInformationIfDataKeyDoesNotExist()
    {
        $this->set_reflection_property_value('data', [ 'id' => 'value' ]);
        $this->set_reflection_property_value('next', 10);
        $this->set_reflection_property_value('previous', 10);

        $method = $this->get_accessible_reflection_method('classify');
        $method->invoke($this->class);

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
        $this->assertPropertySame('next', 0);
        $this->assertPropertySame('previous', 0);
    }

    /**
     * Test that classify sets 'next' to the value fetched from the API, if it is present.
     *
     * @covers Lunr\Spark\Facebook\Feed::classify
     */
    public function testClassifySetsNextIfPresent()
    {
        $data = [
            'data' => [],
            'paging' => [ 'next' => 'https://graph.facebook.com/19292868552/feed?limit=25&until=1375966859' ]
        ];

        $this->set_reflection_property_value('data', $data);

        $method = $this->get_accessible_reflection_method('classify');
        $method->invoke($this->class);

        $this->assertPropertySame('next', 1375966859);
    }

    /**
     * Test that classify sets 'previous' to the value fetched from the API, if it is present.
     *
     * @covers Lunr\Spark\Facebook\Feed::classify
     */
    public function testClassifySetsPreviousIfPresent()
    {
        $data = [
            'data' => [],
            'paging' => [ 'previous' => 'https://graph.facebook.com/19292868552/feed?limit=25&since=1382551720' ]
        ];

        $this->set_reflection_property_value('data', $data);

        $method = $this->get_accessible_reflection_method('classify');
        $method->invoke($this->class);

        $this->assertPropertySame('previous', 1382551720);
    }

    /**
     * Test that classify does not set 'next' if it's omitted in the API output.
     *
     * @covers Lunr\Spark\Facebook\Feed::classify
     */
    public function testClassifyDoesNotTouchNextIfNotPresent()
    {
        $data = [
            'data' => [],
            'paging' => []
        ];

        $this->set_reflection_property_value('data', $data);

        $method = $this->get_accessible_reflection_method('classify');
        $method->invoke($this->class);

        $this->assertPropertySame('next', 0);
    }

    /**
     * Test that classify does not set 'previous' if it's omitted in the API output.
     *
     * @covers Lunr\Spark\Facebook\Feed::classify
     */
    public function testClassifyDoesNotTouchPreviousIfNotPresent()
    {
        $data = [
            'data' => [],
            'paging' => []
        ];

        $this->set_reflection_property_value('data', $data);

        $method = $this->get_accessible_reflection_method('classify');
        $method->invoke($this->class);

        $this->assertPropertySame('previous', 0);
    }

    /**
     * Test that classify() transforms the data array to an array of Post classes.
     *
     * @covers Lunr\Spark\Facebook\Feed::classify
     */
    public function testClassifyTransformsDataToArrayOfPosts()
    {
        $data = [
            'data' => [
                [ 'id' => '1' ],
                [ 'id' => '2' ],
                [ 'id' => '3' ]
            ]
        ];

        $this->set_reflection_property_value('data', $data);

        $method = $this->get_accessible_reflection_method('classify');
        $method->invoke($this->class);

        $value = $this->get_reflection_property_value('data');

        $this->assertInternalType('array', $value);
        $this->assertCount(3, $value);
        $this->assertContainsOnlyInstancesOf('Lunr\Spark\Facebook\Post', $value);
    }

    /**
     * Test that classify creates the Post classes with correct data.
     *
     * @covers Lunr\Spark\Facebook\Feed::classify
     */
    public function testClassifyCreatesPostWithCorrectData()
    {
        $data = [
            'data' => [
                [ 'id' => '1' ]
            ]
        ];

        $this->set_reflection_property_value('data', $data);

        $method = $this->get_accessible_reflection_method('classify');
        $method->invoke($this->class);

        $value = $this->get_reflection_property_value('data');

        $post = new ReflectionClass($value[0]);

        $property = $post->getProperty('data');
        $property->setAccessible(TRUE);

        $this->assertSame($data['data'][0], $property->getValue($value[0]));
    }

    /**
     * Test that classify passes the correct permissions when creating Post classes.
     *
     * @covers Lunr\Spark\Facebook\Feed::classify
     */
    public function testClassifyCreatesPostWithCorrectPermissions()
    {
        $data = [
            'data' => [
                [ 'id' => '1' ]
            ]
        ];

        $permissions = [ 'email' ];

        $this->set_reflection_property_value('data', $data);
        $this->set_reflection_property_value('permissions', $permissions);

        $method = $this->get_accessible_reflection_method('classify');
        $method->invoke($this->class);

        $value = $this->get_reflection_property_value('data');

        $post = new ReflectionClass($value[0]);

        $property = $post->getProperty('permissions');
        $property->setAccessible(TRUE);

        $this->assertSame($permissions, $property->getValue($value[0]));
    }

    /**
     * Test that classify passes the correct used_access_token flag when creating Post classes.
     *
     * @covers Lunr\Spark\Facebook\Feed::classify
     */
    public function testClassifyCreatesPostWithCorrectUsedAccessTokenFlag()
    {
        $data = [
            'data' => [
                [ 'id' => '1' ]
            ]
        ];

        $this->set_reflection_property_value('data', $data);
        $this->set_reflection_property_value('used_access_token', TRUE);

        $method = $this->get_accessible_reflection_method('classify');
        $method->invoke($this->class);

        $value = $this->get_reflection_property_value('data');

        $post = new ReflectionClass($value[0]);

        $property = $post->getProperty('used_access_token');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($value[0]));
    }

}

?>
