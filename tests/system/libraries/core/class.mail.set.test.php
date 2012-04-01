<?php

/**
 * This file contains the MailSetTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the setters in the Mail class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Mail
 */
class MailSetTest extends MailTest
{

    /**
     * Test the fluid interface of the set_from method.
     *
     * @covers Lunr\Libraries\Core\Mail::set_from
     */
    public function testSetFromReturnsSelfReference()
    {
        $result = $this->mail->set_from('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Libraries\Core\Mail', $result);
        $this->assertSame($this->mail, $result);
    }

    /**
     * Test that trying to set an invalid email as From will not do anything
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testFromEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::set_from
     */
    public function testSetInvalidEmailAsFromDoesNothing()
    {
        $property = $this->mail_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $this->mail->set_from(NULL);

        $this->assertEquals('', $property->getValue($this->mail));
    }

    /**
     * Test setting a valid email as From
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testFromEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::set_from
     */
    public function testSetValidEmailAsFrom()
    {
        $property = $this->mail_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $this->mail->set_from('info@m2mobi.com');

        $this->assertEquals('info@m2mobi.com', $property->getValue($this->mail));
    }

    /**
     * Test the fluid interface of the add_to method.
     *
     * @covers Lunr\Libraries\Core\Mail::add_to
     */
    public function testAddToReturnsSelfReference()
    {
        $result = $this->mail->add_to('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Libraries\Core\Mail', $result);
        $this->assertSame($this->mail, $result);
    }

    /**
     * Test that trying to add an invalid email as To will not do anything
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testToEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::add_to
     */
    public function testAddInvalidEmailAsToDoesNothing()
    {
        $property = $this->mail_reflection->getProperty('to');
        $property->setAccessible(TRUE);

        $this->mail->add_to(NULL);

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test adding a valid email as To
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testToEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::add_to
     */
    public function testAddValidEmailAsTo()
    {
        $property = $this->mail_reflection->getProperty('to');
        $property->setAccessible(TRUE);

        $this->mail->add_to('info@m2mobi.com');

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertCount(1, $value);
    }

    /**
     * Test adding more than one valid email as To
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testToEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::add_to
     */
    public function testAddAnotherEmailAsTo()
    {
        $property = $this->mail_reflection->getProperty('to');
        $property->setAccessible(TRUE);

        $this->mail->add_to('info@m2mobi.com');
        $this->mail->add_to('jobs@m2mobi.com');

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertContains('jobs@m2mobi.com', $value);
        $this->assertCount(2, $value);
    }

    /**
     * Test the fluid interface of the add_cc method.
     *
     * @covers Lunr\Libraries\Core\Mail::add_cc
     */
    public function testAddCCReturnsSelfReference()
    {
        $result = $this->mail->add_cc('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Libraries\Core\Mail', $result);
        $this->assertSame($this->mail, $result);
    }

    /**
     * Test that trying to add an invalid email as CC will not do anything
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testCCEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::add_cc
     */
    public function testAddInvalidEmailAsCCDoesNothing()
    {
        $property = $this->mail_reflection->getProperty('cc');
        $property->setAccessible(TRUE);

        $this->mail->add_cc(NULL);

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test adding a valid email as CC
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testCCEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::add_cc
     */
    public function testAddValidEmailAsCC()
    {
        $property = $this->mail_reflection->getProperty('cc');
        $property->setAccessible(TRUE);

        $this->mail->add_cc('info@m2mobi.com');

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertCount(1, $value);
    }

    /**
     * Test adding more than one valid email as CC
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testCCEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::add_cc
     */
    public function testAddAnotherEmailAsCC()
    {
        $property = $this->mail_reflection->getProperty('cc');
        $property->setAccessible(TRUE);

        $this->mail->add_cc('info@m2mobi.com');
        $this->mail->add_cc('jobs@m2mobi.com');

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertContains('jobs@m2mobi.com', $value);
        $this->assertCount(2, $value);
    }

    /**
     * Test the fluid interface of the add_bcc method.
     *
     * @covers Lunr\Libraries\Core\Mail::add_bcc
     */
    public function testAddBCCReturnsSelfReference()
    {
        $result = $this->mail->add_bcc('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Libraries\Core\Mail', $result);
        $this->assertSame($this->mail, $result);
    }

    /**
     * Test that trying to add an invalid email as BCC will not do anything
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testBCCEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::add_bcc
     */
    public function testAddInvalidEmailAsBCCDoesNothing()
    {
        $property = $this->mail_reflection->getProperty('bcc');
        $property->setAccessible(TRUE);

        $this->mail->add_bcc(NULL);

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test adding a valid email as BCC
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testBCCEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::add_bcc
     */
    public function testAddValidEmailAsBCC()
    {
        $property = $this->mail_reflection->getProperty('bcc');
        $property->setAccessible(TRUE);

        $this->mail->add_bcc('info@m2mobi.com');

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertCount(1, $value);
    }

    /**
     * Test adding more than one valid email as BCC
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testBCCEmptyByDefault
     * @depends Lunr\Libraries\Core\MailBaseTest::testInvalidEmailIsNotValid
     * @covers  Lunr\Libraries\Core\Mail::add_bcc
     */
    public function testAddAnotherEmailAsBCC()
    {
        $property = $this->mail_reflection->getProperty('bcc');
        $property->setAccessible(TRUE);

        $this->mail->add_bcc('info@m2mobi.com');
        $this->mail->add_bcc('jobs@m2mobi.com');

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertContains('info@m2mobi.com', $value);
        $this->assertContains('jobs@m2mobi.com', $value);
        $this->assertCount(2, $value);
    }

    /**
     * Test the fluid interface of the set_message method.
     *
     * @covers Lunr\Libraries\Core\Mail::set_message
     */
    public function testSetMessageReturnsSelfReference()
    {
        $result = $this->mail->set_message('Message');

        $this->assertInstanceOf('Lunr\Libraries\Core\Mail', $result);
        $this->assertSame($this->mail, $result);
    }

    /**
     * Test setting a message.
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testMessageEmptyByDefault
     * @covers  Lunr\Libraries\Core\Mail::set_message
     */
    public function testSetMessage()
    {
        $property = $this->mail_reflection->getProperty('msg');
        $property->setAccessible(TRUE);

        $this->mail->set_message('Message');

        $this->assertEquals('Message', $property->getValue($this->mail));
    }

    /**
     * Test the fluid interface of the set_subject method.
     *
     * @covers Lunr\Libraries\Core\Mail::set_subject
     */
    public function testSetSubjectReturnsSelfReference()
    {
        $result = $this->mail->set_subject('Subject');

        $this->assertInstanceOf('Lunr\Libraries\Core\Mail', $result);
        $this->assertSame($this->mail, $result);
    }

    /**
     * Test setting a subject.
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testMessageEmptyByDefault
     * @covers  Lunr\Libraries\Core\Mail::set_message
     */
    public function testSetSubject()
    {
        $property = $this->mail_reflection->getProperty('subject');
        $property->setAccessible(TRUE);

        $this->mail->set_subject('Subject');

        $this->assertEquals('Subject', $property->getValue($this->mail));
    }

}

?>
