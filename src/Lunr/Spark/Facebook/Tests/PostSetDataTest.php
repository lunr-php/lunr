<?php

/**
 * This file contains the PostSetDataTest class.
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

/**
 * This class contains the tests for the Facebook Post class.
 *
 * @covers Lunr\Spark\Facebook\Post
 */
class PostSetDataTest extends PostTest
{

    /**
     * Test the fluid interface of set_data().
     *
     * @covers Lunr\Spark\Facebook\Post::set_data
     */
    public function testSetDataReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_data([], [], TRUE));
    }

    /**
     * Test that set_data() sets the passed data.
     *
     * @covers Lunr\Spark\Facebook\Post::set_data
     */
    public function testSetDataSetsData(): void
    {
        $data = [ 'id' => '123', 'name' => 'name' ];

        $this->class->set_data($data, [], TRUE);

        $this->assertPropertySame('data', $data);
    }

    /**
     * Test that set_data() sets the passed permissions.
     *
     * @covers Lunr\Spark\Facebook\Post::set_data
     */
    public function testSetDataSetsPermissions(): void
    {
        $permissions = [ 'email', 'read_stream' ];

        $this->class->set_data([], $permissions, TRUE);

        $this->assertPropertySame('permissions', $permissions);
    }

    /**
     * Test that set_data() sets the passed used_access_token boolean.
     *
     * @covers Lunr\Spark\Facebook\Post::set_data
     */
    public function testSetDataSetsUsedAccessToken(): void
    {
        $this->class->set_data([], [], TRUE);
        $this->assertTrue($this->get_reflection_property_value('used_access_token'));
    }

    /**
     * Test that set_data() unsets post comments.
     *
     * @covers Lunr\Spark\Facebook\Post::set_data
     */
    public function testSetDataUnsetsComments(): void
    {
        $data = [ 'id' => '123', 'comments' => [] ];

        $this->class->set_data($data, [], TRUE);

        $this->assertPropertySame('data', [ 'id' => '123' ]);
    }

    /**
     * Test that set_data() unsets post likes.
     *
     * @covers Lunr\Spark\Facebook\Post::set_data
     */
    public function testSetDataUnsetsLikes(): void
    {
        $data = [ 'id' => '123', 'likes' => [] ];

        $this->class->set_data($data, [], TRUE);

        $this->assertPropertySame('data', [ 'id' => '123' ]);
    }

}

?>
