<?php

/**
 * This file contains the EmailDispatcherBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the EmailDispatcher class.
 *
 * @covers Lunr\Vortex\Email\EmailDispatcher
 */
class EmailDispatcherBaseTest extends EmailDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the source is set to an empty string by default.
     */
    public function testSourceIsEmptyString()
    {
        $this->assertPropertyEmpty('source');
    }

    /**
     * Test that the passed Mail object is set correctly.
     */
    public function testMailIsSetCorrectly()
    {
        $this->assertSame($this->mail_transport, $this->get_reflection_property_value('mail_transport'));
    }

    /**
     * Test that clone_mail() returns a cloned email transport class.
     *
     * @covers Lunr\Vortex\Email\EmailDispatcher::clone_mail
     */
    public function testCloneMailReturnsClonedMailClass()
    {
        $method = $this->get_accessible_reflection_method('clone_mail');

        $mail = $method->invoke($this->class);

        $this->assertNotSame($mail, $this->mail_transport);
    }

}

?>
