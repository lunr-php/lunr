<?php

/**
 * This file contains the EmailPayloadSetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

/**
 * This class contains tests for the setters of the EmailPayload class.
 *
 * @covers Lunr\Vortex\Email\EmailPayload
 */
class EmailPayloadSetTest extends EmailPayloadTest
{

    /**
     * Test set_subject() works correctly.
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_subject
     */
    public function testSetSubject()
    {
        $this->class->set_subject('subject');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('subject', $value);
        $this->assertEquals(['subject' => 'subject'], $value);
    }

    /**
     * Test fluid interface of set_subject().
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_subject
     */
    public function testSetSubjectReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_subject('subject'));
    }

    /**
     * Test set_body() works correctly.
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_body
     */
    public function testSetBody()
    {
        $this->class->set_body('body');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('body', $value);
        $this->assertEquals(['body' => 'body'], $value);
    }

    /**
     * Test fluid interface of set_body().
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_body
     */
    public function testSetBodyReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_body('subject'));
    }

}

?>
