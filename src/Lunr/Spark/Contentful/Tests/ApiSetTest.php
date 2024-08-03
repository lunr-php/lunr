<?php

/**
 * This file contains the ApiSetTest class.
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
class ApiSetTest extends ApiTest
{

    /**
     * Test that set_space_id() sets the space ID correctly.
     *
     * @covers Lunr\Spark\Contentful\Api::set_space_id
     */
    public function testSetSpaceIdSetsSpaceId(): void
    {
        $this->class->set_space_id('space');

        $this->assertPropertyEquals('space', 'space');
    }

    /**
     * Test the fluid interface of set_space_id().
     *
     * @covers Lunr\Spark\Contentful\Api::set_space_id
     */
    public function testSetSpaceIdReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_space_id('space'));
    }

    /**
     * Test that set_environment() sets the environment correctly.
     *
     * @covers Lunr\Spark\Contentful\Api::set_environment
     */
    public function testSetEnvironmentSetsEnvironment(): void
    {
        $this->class->set_environment('master');

        $this->assertPropertyEquals('environment', 'master');
    }

    /**
     * Test the fluid interface of set_environment().
     *
     * @covers Lunr\Spark\Contentful\Api::set_environment
     */
    public function testSetEnvironmentReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_environment('master'));
    }

}

?>
