<?php

/**
 * This file contains the MailSetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

/**
 * This class contains test methods for the setters in the Mail class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\Mail
 */
class MailSetTest extends MailTest
{

    /**
     * Test the fluid interface of the set_from method.
     *
     * @covers Lunr\Network\Mail::set_from
     */
    public function testSetFromReturnsSelfReference()
    {
        $result = $this->class->set_from('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->class, $result);
    }

    /**
     * Test that trying to set an invalid email as From will not do anything.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testFromEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::set_from
     */
    public function testSetInvalidEmailAsFromDoesNothing()
    {
        $this->class->set_from(NULL);

        $this->assertPropertyEquals('from', '');
    }

    /**
     * Test setting a valid email as From.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testFromEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::set_from
     */
    public function testSetValidEmailAsFrom()
    {
        $this->class->set_from('info@m2mobi.com');

        $this->assertPropertyEquals('from', 'info@m2mobi.com');
    }

    /**
     * Test the fluid interface of the add_to method.
     *
     * @covers Lunr\Network\Mail::add_to
     */
    public function testAddToReturnsSelfReference()
    {
        $result = $this->class->add_to('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->class, $result);
    }

    /**
     * Test that trying to add an invalid email as To will not do anything.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testToEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::add_to
     */
    public function testAddInvalidEmailAsToDoesNothing()
    {
        $this->class->add_to(NULL);

        $value = $this->get_reflection_property_value('to');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test adding a valid email as To.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testToEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::add_to
     */
    public function testAddValidEmailAsTo()
    {
        $this->class->add_to('info@m2mobi.com');

        $value = $this->get_reflection_property_value('to');

        $this->assertArrayNotEmpty($value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertCount(1, $value);
    }

    /**
     * Test adding more than one valid email as To.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testToEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::add_to
     */
    public function testAddAnotherEmailAsTo()
    {
        $this->class->add_to('info@m2mobi.com');
        $this->class->add_to('jobs@m2mobi.com');

        $value = $this->get_reflection_property_value('to');

        $this->assertArrayNotEmpty($value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertContains('jobs@m2mobi.com', $value);
        $this->assertCount(2, $value);
    }

    /**
     * Test the fluid interface of the add_cc method.
     *
     * @covers Lunr\Network\Mail::add_cc
     */
    public function testAddCCReturnsSelfReference()
    {
        $result = $this->class->add_cc('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->class, $result);
    }

    /**
     * Test that trying to add an invalid email as CC will not do anything.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testCCEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::add_cc
     */
    public function testAddInvalidEmailAsCCDoesNothing()
    {
        $this->class->add_cc(NULL);

        $value = $this->get_reflection_property_value('cc');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test adding a valid email as CC.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testCCEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::add_cc
     */
    public function testAddValidEmailAsCC()
    {
        $this->class->add_cc('info@m2mobi.com');

        $value = $this->get_reflection_property_value('cc');

        $this->assertArrayNotEmpty($value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertCount(1, $value);
    }

    /**
     * Test adding more than one valid email as CC.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testCCEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::add_cc
     */
    public function testAddAnotherEmailAsCC()
    {
        $this->class->add_cc('info@m2mobi.com');
        $this->class->add_cc('jobs@m2mobi.com');

        $value = $this->get_reflection_property_value('cc');

        $this->assertArrayNotEmpty($value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertContains('jobs@m2mobi.com', $value);
        $this->assertCount(2, $value);
    }

    /**
     * Test the fluid interface of the add_bcc method.
     *
     * @covers Lunr\Network\Mail::add_bcc
     */
    public function testAddBCCReturnsSelfReference()
    {
        $result = $this->class->add_bcc('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->class, $result);
    }

    /**
     * Test that trying to add an invalid email as BCC will not do anything.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testBCCEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::add_bcc
     */
    public function testAddInvalidEmailAsBCCDoesNothing()
    {
        $this->class->add_bcc(NULL);

        $value = $this->get_reflection_property_value('bcc');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test adding a valid email as BCC.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testBCCEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::add_bcc
     */
    public function testAddValidEmailAsBCC()
    {
        $this->class->add_bcc('info@m2mobi.com');

        $value = $this->get_reflection_property_value('bcc');

        $this->assertArrayNotEmpty($value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertCount(1, $value);
    }

    /**
     * Test adding more than one valid email as BCC.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testBCCEmptyByDefault
     * @depends Lunr\Network\Tests\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Network\Mail::add_bcc
     */
    public function testAddAnotherEmailAsBCC()
    {
        $this->class->add_bcc('info@m2mobi.com');
        $this->class->add_bcc('jobs@m2mobi.com');

        $value = $this->get_reflection_property_value('bcc');

        $this->assertArrayNotEmpty($value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertContains('jobs@m2mobi.com', $value);
        $this->assertCount(2, $value);
    }

    /**
     * Test the fluid interface of the set_message method.
     *
     * @covers Lunr\Network\Mail::set_message
     */
    public function testSetMessageReturnsSelfReference()
    {
        $result = $this->class->set_message('Message');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->class, $result);
    }

    /**
     * Test setting a message.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testMessageEmptyByDefault
     * @covers  Lunr\Network\Mail::set_message
     */
    public function testSetMessage()
    {
        $this->class->set_message('Message');

        $this->assertPropertyEquals('msg', 'Message');
    }

    /**
     * Test the fluid interface of the set_subject method.
     *
     * @covers Lunr\Network\Mail::set_subject
     */
    public function testSetSubjectReturnsSelfReference()
    {
        $result = $this->class->set_subject('Subject');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->class, $result);
    }

    /**
     * Test setting a subject.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testSubjectEmptyByDefault
     * @covers  Lunr\Network\Mail::set_message
     */
    public function testSetSubject()
    {
        $property = $this->get_reflection_property_value('subject');

        $this->class->set_subject('Subject');

        $this->assertPropertyEquals('subject', 'Subject');
    }

    /**
     * Test resetting all values.
     *
     * @covers Lunr\Network\Mail::reset
     */
    public function testReset()
    {
        $this->set_reflection_property_value('msg', 'message');
        $this->set_reflection_property_value('from', 'from@email.com');
        $this->set_reflection_property_value('subject', 'subject');

        $this->set_reflection_property_value('to', [ 'to@mail.com' ]);
        $this->set_reflection_property_value('cc', [ 'cc@mail.com' ]);
        $this->set_reflection_property_value('bcc', [ 'bcc@mail.com' ]);

        $method = $this->get_accessible_reflection_method('reset');
        $method->invoke($this->class);

        $this->assertPropertyEmpty('msg');
        $this->assertPropertyEmpty('from');
        $this->assertPropertyEmpty('subject');
        $this->assertArrayEmpty($this->get_reflection_property_value('to'));
        $this->assertArrayEmpty($this->get_reflection_property_value('cc'));
        $this->assertArrayEmpty($this->get_reflection_property_value('bcc'));
    }

}

?>
