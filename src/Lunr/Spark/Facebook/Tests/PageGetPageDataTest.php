<?php

/**
 * This file contains the PageGetPageDataTest class.
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

use Lunr\Spark\Facebook\Page;
use Lunr\Spark\DataError;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook Page class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Page
 */
class PageGetPageDataTest extends PageTest
{

    /**
     * Test that getting page data return NOT_REQUESTED when using fields and requested field was not requested.
     *
     * @covers Lunr\Spark\Facebook\Page::__call
     */
    public function testGetPageDataReturnsNotRequestedWhenUsingFields()
    {
        $this->set_reflection_property_value('fields', [ 'foo' ]);

        $this->assertSame(DataError::NOT_REQUESTED, $this->class->get_bar());
    }

    /**
     * Test that getting public page data returns the data if it is present.
     *
     * @param String $field Field name
     *
     * @dataProvider publicFieldsProvider
     * @covers       Lunr\Spark\Facebook\Page::__call
     */
    public function testGetPageDataReturnsDataIfPresent($field)
    {
        $this->set_reflection_property_value('data', [ $field => 'Value' ]);

        $this->assertEquals('Value', $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting public page data returns NOT_AVAILABLE if it is not present.
     *
     * @param String $field Field name
     *
     * @dataProvider publicFieldsProvider
     * @covers       Lunr\Spark\Facebook\Page::__call
     */
    public function testGetPageDataReturnsNotAvailableIfNotPresent($field)
    {
        $this->assertSame(DataError::NOT_AVAILABLE, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting the page access token returns the data if it is present.
     *
     * @covers Lunr\Spark\Facebook\Page::__call
     */
    public function testGetPageAccessTokenReturnsDataIfPresent()
    {
        $this->set_reflection_property_value('fields', [ 'access_token' ]);
        $this->set_reflection_property_value('permissions', [ 'manage_pages' => 1 ]);
        $this->set_reflection_property_value('data', [ 'access_token' => 'Value' ]);

        $this->assertEquals('Value', $this->class->get_access_token());
    }

    /**
     * Test that getting the page access token returns NOT_AVAILABLE if it is not present.
     *
     * @covers Lunr\Spark\Facebook\Page::__call
     */
    public function testGetPageAccessTokenReturnsNotAvailableIfNotPresent()
    {
        $this->set_reflection_property_value('fields', [ 'access_token' ]);
        $this->set_reflection_property_value('permissions', [ 'manage_pages' => 1 ]);

        $this->assertSame(DataError::NOT_AVAILABLE, $this->class->get_access_token());
    }

    /**
     * Test that getting the page access token returns ACCESS_DENIED if permission is missing.
     *
     * @covers Lunr\Spark\Facebook\Page::__call
     */
    public function testGetPageAccessTokenReturnsAccessDeniedIfPermissionMissing()
    {
        $this->set_reflection_property_value('fields', [ 'access_token' ]);

        $message = 'Access to "{field}" requires "{permission}" permission.';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message));

        $this->assertSame(DataError::ACCESS_DENIED, $this->class->get_access_token());
    }

    /**
     * Test that getting the page access token returns NOT_REQUESTED if it was not requested.
     *
     * @covers Lunr\Spark\Facebook\Page::__call
     */
    public function testGetPageAccessTokenReturnsNotRequestedIfNotRequested()
    {
        $message = 'Access to "{field}" needs to be requested specifically.';
        $context = [ 'field' => 'access_token' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $this->assertSame(DataError::NOT_REQUESTED, $this->class->get_access_token());
    }

    /**
     * Test that getting unknown page data returns UNKNOWN_FIELD.
     *
     * @covers Lunr\Spark\Facebook\Page::__call
     */
    public function testGetPageDataReturnsUnknownFieldForUnknownFields()
    {
        $this->assertSame(DataError::UNKNOWN_FIELD, $this->class->get_unknown_field());
    }

}

?>
