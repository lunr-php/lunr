<?php

/**
 * This file contains the ApiSetTest class.
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Spark\Contentful\Api;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

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
