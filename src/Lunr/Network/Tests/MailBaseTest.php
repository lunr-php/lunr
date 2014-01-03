<?php

/**
 * This file contains the MailBaseTest class.
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
 * This class contains test methods for the Mail class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\Mail
 */
class MailBaseTest extends MailTest
{

    /**
     * Test that from property from is empty by default.
     */
    public function testFromEmptyByDefault()
    {
        $this->assertPropertyEquals('from', '');
    }

    /**
     * Test that from property msg is empty by default.
     */
    public function testMessageEmptyByDefault()
    {
        $this->assertPropertyEquals('msg', '');
    }

    /**
     * Test that from property subject is empty by default.
     */
    public function testSubjectEmptyByDefault()
    {
        $this->assertPropertyEquals('subject', '');
    }

    /**
     * Test that property to is an empty array by default.
     */
    public function testToEmptyByDefault()
    {
        $value = $this->get_reflection_property_value('to');
        $this->assertArrayEmpty($value);
    }

    /**
     * Test that property cc is an empty array by default.
     */
    public function testCCEmptyByDefault()
    {
        $value = $this->get_reflection_property_value('cc');
        $this->assertArrayEmpty($value);
    }

    /**
     * Test that property bcc is an empty array by default.
     */
    public function testBCCEmptyByDefault()
    {
        $value = $this->get_reflection_property_value('bcc');
        $this->assertArrayEmpty($value);
    }

    /**
     * Test that a valid email is correctly marked as valid.
     *
     * @param String $email An email to test
     *
     * @dataProvider validEmailProvider
     * @covers       Lunr\Network\Mail::is_valid
     */
    public function testValidEmailIsValid($email)
    {
        $this->assertTrue($this->class->is_valid($email));
    }

    /**
     * Test that an invalid email is correctly marked as invalid.
     *
     * @param String $email An email to test
     *
     * @dataProvider invalidEmailProvider
     * @covers       Lunr\Network\Mail::is_valid
     */
    public function testInvalidEmailIsNotValid($email)
    {
        $this->assertFalse($this->class->is_valid($email));
    }

}

?>
