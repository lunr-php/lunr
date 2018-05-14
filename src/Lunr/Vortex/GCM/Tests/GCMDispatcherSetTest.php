<?php

/**
 * This file contains the GCMDispatcherSetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

/**
 * This class contains tests for the setters of the GCMDispatcher class.
 *
 * @covers Lunr\Vortex\GCM\GCMDispatcher
 */
class GCMDispatcherSetTest extends GCMDispatcherTest
{

    /**
     * Test that set_auth_token() sets the endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_auth_token
     */
    public function testSetAuthTokenSetsPayload()
    {
        $this->class->set_auth_token('auth_token');

        $this->assertPropertyEquals('auth_token', 'auth_token');
    }

    /**
     * Test the fluid interface of set_auth_token().
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_auth_token
     */
    public function testSetAuthTokenReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_auth_token('auth_token'));
    }

    /**
     * Test that set_priority() sets the priority.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_priority
     */
    public function testSetPrioritySetsPayload()
    {
        $this->class->set_priority('priority');

        $this->assertPropertyEquals('priority', 'priority');
    }

    /**
     * Test the fluid interface of set_priority().
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_priority
     */
    public function testSetPriorityReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_priority('high'));
    }

}

?>
