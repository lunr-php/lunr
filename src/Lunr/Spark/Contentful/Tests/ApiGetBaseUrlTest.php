<?php

/**
 * This file contains the ApiGetBaseUrlTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Contentful\Tests;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Contentful\Api
 */
class ApiGetBaseUrlTest extends ApiTest
{

    /**
     * Test that get_base_url() without values
     *
     * @covers Lunr\Spark\Contentful\Api::get_base_url
     */
    public function testGetBaseUrlWithoutValues(): void
    {
        $method = $this->get_accessible_reflection_method('get_base_url');
        $result = $method->invoke($this->class);

        $this->assertSame('https://www.contentful.com', $result);
    }

    /**
     * Test that get_base_url() with only space
     *
     * @covers Lunr\Spark\Contentful\Api::get_base_url
     */
    public function testGetBaseUrlWithOnlySpace(): void
    {
        $this->set_reflection_property_value('space', '5p4c31D');

        $method = $this->get_accessible_reflection_method('get_base_url');
        $result = $method->invoke($this->class);

        $this->assertSame('https://www.contentful.com/spaces/5p4c31D', $result);
    }

    /**
     * Test that get_base_url() with only environment
     *
     * @covers Lunr\Spark\Contentful\Api::get_base_url
     */
    public function testGetBaseUrlWithOnlyEnvironment(): void
    {
        $this->set_reflection_property_value('environment', 'master');

        $method = $this->get_accessible_reflection_method('get_base_url');
        $result = $method->invoke($this->class);

        $this->assertSame('https://www.contentful.com/environments/master', $result);
    }

    /**
     * Test that get_base_url() with all values
     *
     * @covers Lunr\Spark\Contentful\Api::get_base_url
     */
    public function testGetBaseUrlWithAllValues(): void
    {
        $this->set_reflection_property_value('space', '5p4c31D');
        $this->set_reflection_property_value('environment', 'master');

        $method = $this->get_accessible_reflection_method('get_base_url');
        $result = $method->invoke($this->class);

        $this->assertSame('https://www.contentful.com/spaces/5p4c31D/environments/master', $result);
    }

}

?>
