<?php

/**
 * This file contains the EmailDispatcherSetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

/**
 * This class contains tests for the setters of the EmailDispatcher class.
 *
 * @covers Lunr\Vortex\Email\EmailDispatcher
 */
class EmailDispatcherSetTest extends EmailDispatcherTest
{

    /**
     * Test that set_source() sets the auth_token.
     *
     * @covers Lunr\Vortex\Email\EmailDispatcher::set_source
     */
    public function testSetSourceSetsSource()
    {
        $source = 'source';
        $this->class->set_source($source);

        $this->assertPropertyEquals('source', 'source');
    }

    /**
     * Test the fluid interface of set_source().
     *
     * @covers Lunr\Vortex\Email\EmailDispatcher::set_source
     */
    public function testSetSourceReturnsSelfReference()
    {
        $source = 'source';
        $this->assertEquals($this->class, $this->class->set_source($source));
    }

}

?>
