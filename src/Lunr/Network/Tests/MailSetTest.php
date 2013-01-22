<?php

/**
 * This file contains the MailSetTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Network\Mail;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the setters in the Mail class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
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
        $result = $this->mail->set_from('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->mail, $result);
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
        $property = $this->mail_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $this->mail->set_from(NULL);

        $this->assertEquals('', $property->getValue($this->mail));
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
        $property = $this->mail_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $this->mail->set_from('info@m2mobi.com');

        $this->assertEquals('info@m2mobi.com', $property->getValue($this->mail));
    }

    /**
     * Test the fluid interface of the add_to method.
     *
     * @covers Lunr\Network\Mail::add_to
     */
    public function testAddToReturnsSelfReference()
    {
        $result = $this->mail->add_to('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->mail, $result);
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
        $property = $this->mail_reflection->getProperty('to');
        $property->setAccessible(TRUE);

        $this->mail->add_to(NULL);

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
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
        $property = $this->mail_reflection->getProperty('to');
        $property->setAccessible(TRUE);

        $this->mail->add_to('info@m2mobi.com');

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
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
     * @covers Lunr\Network\Mail::add_cc
     */
    public function testAddCCReturnsSelfReference()
    {
        $result = $this->mail->add_cc('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->mail, $result);
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
        $property = $this->mail_reflection->getProperty('cc');
        $property->setAccessible(TRUE);

        $this->mail->add_cc(NULL);

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
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
        $property = $this->mail_reflection->getProperty('cc');
        $property->setAccessible(TRUE);

        $this->mail->add_cc('info@m2mobi.com');

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
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
     * @covers Lunr\Network\Mail::add_bcc
     */
    public function testAddBCCReturnsSelfReference()
    {
        $result = $this->mail->add_bcc('info@m2mobi.com');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->mail, $result);
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
        $property = $this->mail_reflection->getProperty('bcc');
        $property->setAccessible(TRUE);

        $this->mail->add_bcc(NULL);

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
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
        $property = $this->mail_reflection->getProperty('bcc');
        $property->setAccessible(TRUE);

        $this->mail->add_bcc('info@m2mobi.com');

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
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
     * @covers Lunr\Network\Mail::set_message
     */
    public function testSetMessageReturnsSelfReference()
    {
        $result = $this->mail->set_message('Message');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->mail, $result);
    }

    /**
     * Test setting a message.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testMessageEmptyByDefault
     * @covers  Lunr\Network\Mail::set_message
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
     * @covers Lunr\Network\Mail::set_subject
     */
    public function testSetSubjectReturnsSelfReference()
    {
        $result = $this->mail->set_subject('Subject');

        $this->assertInstanceOf('Lunr\Network\Mail', $result);
        $this->assertSame($this->mail, $result);
    }

    /**
     * Test setting a subject.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testMessageEmptyByDefault
     * @covers  Lunr\Network\Mail::set_message
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
