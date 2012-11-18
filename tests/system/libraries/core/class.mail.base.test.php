<?php

/**
 * This file contains the MailBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the Mail class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Mail
 */
class MailBaseTest extends MailTest
{

    /**
     * Test that the default sender address is empty.
     */
    public function testFromEmptyByDefault()
    {
        $property = $this->mail_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->mail));
    }

    /**
     * Test that the default receiver address is empty.
     */
    public function testToEmptyByDefault()
    {
        $property = $this->mail_reflection->getProperty('to');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the default CC address is empty.
     */
    public function testCCEmptyByDefault()
    {
        $property = $this->mail_reflection->getProperty('cc');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the default BCC address is empty.
     */
    public function testBCCEmptyByDefault()
    {
        $property = $this->mail_reflection->getProperty('bcc');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->mail);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the default message is empty.
     */
    public function testMessageEmptyByDefault()
    {
        $property = $this->mail_reflection->getProperty('msg');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->mail));
    }

    /**
     * Test that the default subject is empty.
     */
    public function testSubjectEmptyByDefault()
    {
        $property = $this->mail_reflection->getProperty('subject');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->mail));
    }

    /**
     * Test that a valid email is correctly marked as valid.
     *
     * @param String $email An email to test
     *
     * @dataProvider validEmailProvider
     * @covers       Lunr\Libraries\Core\Mail::is_valid
     */
    public function testValidEmailIsValid($email)
    {
        $this->assertTrue($this->mail->is_valid($email));
    }

    /**
     * Test that an invalid email is correctly marked as invalid.
     *
     * @param String $email An email to test
     *
     * @dataProvider invalidEmailProvider
     * @covers       Lunr\Libraries\Core\Mail::is_valid
     */
    public function testInvalidEmailIsNotValid($email)
    {
        $this->assertFalse($this->mail->is_valid($email));
    }

}

?>
