<?php

/**
 * This file contains the DeliveryApiSetSpaceIdTest class.
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Spark\Contentful\DeliveryApi;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the DeliveryApi.
 *
 * @covers Lunr\Spark\Contentful\DeliveryApi
 */
class DeliveryApiSetSpaceIdTest extends DeliveryApiTest
{

    /**
     * Test that set_space_id() sets the space ID correctly.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::set_space_id
     */
    public function testSetSpaceIdSetsSpaceId()
    {
        $this->class->set_space_id('space');

        $this->assertPropertyEquals('space', 'space');
    }

    /**
     * Test the fluid interface of set_space_id().
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::set_space_id
     */
    public function testSetSpaceIdReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_space_id('space'));
    }

}

?>
