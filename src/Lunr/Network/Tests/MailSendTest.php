<?php

/**
 * This file contains the MailSendTest class.
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
 * This class contains test methods for sending emails.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\Mail
 */
class MailSendTest extends MailTest
{

    /**
     * Test that generating carbon copy headers returns an empty string for invalid types.
     *
     * @covers Lunr\Network\Mail::generate_carbon_copy_header
     */
    public function testGeneratingHeadersForInvalidCarbonCopyReturnsEmptyString()
    {
        $method = $this->get_accessible_reflection_method('generate_carbon_copy_header');

        $this->assertEquals('', $method->invokeArgs($this->class, ['invalid']));
    }

    /**
     * Test that generating CC headers when none are defined returns an empty string.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testCCEmptyByDefault
     * @covers  Lunr\Network\Mail::generate_carbon_copy_header
     */
    public function testGeneratingCCHeadersWhenEmptyReturnsEmptyString()
    {
        $method = $this->get_accessible_reflection_method('generate_carbon_copy_header');

        $this->assertEquals('', $method->invokeArgs($this->class, ['cc']));
        $this->assertEquals('', $method->invoke($this->class));
    }

    /**
     * Test that generating BCC headers when none are defined returns an empty string.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testBCCEmptyByDefault
     * @covers  Lunr\Network\Mail::generate_carbon_copy_header
     */
    public function testGeneratingBCCHeadersWhenEmptyReturnsEmptyString()
    {
        $method = $this->get_accessible_reflection_method('generate_carbon_copy_header');

        $this->assertEquals('', $method->invokeArgs($this->class, ['bcc']));
    }

    /**
     * Test generating CC headers with one entry.
     *
     * @covers Lunr\Network\Mail::generate_carbon_copy_header
     */
    public function testGeneratingCCHeadersWithOneEntry()
    {
        $method = $this->get_accessible_reflection_method('generate_carbon_copy_header');

        $this->set_reflection_property_value('cc', ['info@m2mobi.com']);

        $this->assertEquals("CC: info@m2mobi.com\r\n", $method->invokeArgs($this->class, ['cc']));
    }

    /**
     * Test generating CC headers with more than one entry.
     *
     * @covers Lunr\Network\Mail::generate_carbon_copy_header
     */
    public function testGeneratingCCHeadersWithMoreEntries()
    {
        $method = $this->get_accessible_reflection_method('generate_carbon_copy_header');

        $this->set_reflection_property_value('cc', ['info@m2mobi.com', 'jobs@m2mobi.com']);

        $this->assertEquals("CC: info@m2mobi.com, jobs@m2mobi.com\r\n", $method->invokeArgs($this->class, ['cc']));
    }

    /**
     * Test generating BCC headers with one entry.
     *
     * @covers Lunr\Network\Mail::generate_carbon_copy_header
     */
    public function testGeneratingBCCHeadersWithOneEntry()
    {
        $method = $this->get_accessible_reflection_method('generate_carbon_copy_header');

        $this->set_reflection_property_value('bcc', ['info@m2mobi.com']);

        $this->assertEquals("BCC: info@m2mobi.com\r\n", $method->invokeArgs($this->class, ['bcc']));
    }

    /**
     * Test generating BCC headers with more than one entry.
     *
     * @covers Lunr\Network\Mail::generate_carbon_copy_header
     */
    public function testGeneratingBCCHeadersWithMoreEntries()
    {
        $method = $this->get_accessible_reflection_method('generate_carbon_copy_header');

        $this->set_reflection_property_value('bcc', ['info@m2mobi.com', 'jobs@m2mobi.com']);

        $expect = "BCC: info@m2mobi.com, jobs@m2mobi.com\r\n";

        $this->assertEquals($expect, $method->invokeArgs($this->class, ['bcc']));
    }

    /**
     * Test that headers returns FALSE when there is no From address set.
     *
     * @depends Lunr\Network\Tests\MailBaseTest::testFromEmptyByDefault
     * @covers  Lunr\Network\Mail::generate_headers
     */
    public function testHeadersReturnsFalseWhenFromIsEmpty()
    {
        $method = $this->get_accessible_reflection_method('generate_headers');

        $this->assertFalse($method->invoke($this->class));
    }

    /**
     * Test generating headers with neither CC nor BCC set.
     *
     * @depends testGeneratingCCHeadersWhenEmptyReturnsEmptyString
     * @depends testGeneratingBCCHeadersWhenEmptyReturnsEmptyString
     * @covers  Lunr\Network\Mail::generate_headers
     */
    public function testHeadersWithEmptyCCAndEmptyBCC()
    {
        $method = $this->get_accessible_reflection_method('generate_headers');

        $this->set_reflection_property_value('from', 'info@m2mobi.com');

        $expected  = "From: info@m2mobi.com\r\n";
        $expected .= 'X-Mailer: PHP/' . phpversion();

        $this->assertEquals($expected, $method->invoke($this->class));
    }

    /**
     * Test generating headers with CC and without BCC.
     *
     * @depends testGeneratingCCHeadersWithOneEntry
     * @depends testGeneratingCCHeadersWithMoreEntries
     * @depends testGeneratingBCCHeadersWhenEmptyReturnsEmptyString
     * @covers  Lunr\Network\Mail::generate_headers
     */
    public function testHeadersWithCCAndEmptyBCC()
    {
        $method = $this->get_accessible_reflection_method('generate_headers');

        $this->set_reflection_property_value('from', 'info@m2mobi.com');
        $this->set_reflection_property_value('cc', ['jobs@m2mobi.com']);

        $expected  = "From: info@m2mobi.com\r\n";
        $expected .= "CC: jobs@m2mobi.com\r\n";
        $expected .= 'X-Mailer: PHP/' . phpversion();

        $this->assertEquals($expected, $method->invoke($this->class));
    }

    /**
     * Test generating headers without CC and with BCC.
     *
     * @depends testGeneratingCCHeadersWhenEmptyReturnsEmptyString
     * @depends testGeneratingBCCHeadersWithOneEntry
     * @depends testGeneratingBCCHeadersWithMoreEntries
     * @covers  Lunr\Network\Mail::generate_headers
     */
    public function testHeadersWithEmptyCCAndBCC()
    {
        $method = $this->get_accessible_reflection_method('generate_headers');

        $this->set_reflection_property_value('from', 'info@m2mobi.com');
        $this->set_reflection_property_value('bcc', ['jobs@m2mobi.com']);

        $expected  = "From: info@m2mobi.com\r\n";
        $expected .= "BCC: jobs@m2mobi.com\r\n";
        $expected .= 'X-Mailer: PHP/' . phpversion();

        $this->assertEquals($expected, $method->invoke($this->class));
    }

    /**
     * Test generating headers with both CC and BCC set.
     *
     * @depends testGeneratingCCHeadersWithOneEntry
     * @depends testGeneratingCCHeadersWithMoreEntries
     * @depends testGeneratingBCCHeadersWithOneEntry
     * @depends testGeneratingBCCHeadersWithMoreEntries
     * @covers  Lunr\Network\Mail::generate_headers
     */
    public function testHeaders()
    {
        $method = $this->get_accessible_reflection_method('generate_headers');

        $this->set_reflection_property_value('from', 'info@m2mobi.com');

        $this->set_reflection_property_value('cc', ['jobs@m2mobi.com']);

        $this->set_reflection_property_value('bcc', ['jobs@m2mobi.com']);

        $expected  = "From: info@m2mobi.com\r\n";
        $expected .= "CC: jobs@m2mobi.com\r\n";
        $expected .= "BCC: jobs@m2mobi.com\r\n";
        $expected .= 'X-Mailer: PHP/' . phpversion();

        $this->assertEquals($expected, $method->invoke($this->class));
    }

    /**
     * Test sending fails when from is empty.
     *
     * @depends testHeadersReturnsFalseWhenFromIsEmpty
     * @depends Lunr\Network\Tests\MailSetTest::testSetSubject
     * @depends Lunr\Network\Tests\MailSetTest::testAddValidEmailAsTo
     * @covers  Lunr\Network\Mail::send
     */
    public function testSendReturnsFalseWhenFromIsEmpty()
    {
        $this->class->set_subject('Subject');
        $this->class->add_to('jobs@m2mobi.com');

        $this->assertFalse($this->class->send());
    }

    /**
     * Test sending fails when to is empty.
     *
     * @depends Lunr\Network\Tests\MailSetTest::testSetSubject
     * @depends Lunr\Network\Tests\MailSetTest::testSetValidEmailAsFrom
     * @covers  Lunr\Network\Mail::send
     */
    public function testSendReturnsFalseWhenToIsEmpty()
    {
        $this->class->set_subject('Subject');
        $this->class->set_from('info@m2mobi.com');

        $this->assertFalse($this->class->send());
    }

    /**
     * Test sending fails when to is empty.
     *
     * @depends Lunr\Network\Tests\MailSetTest::testAddValidEmailAsTo
     * @depends Lunr\Network\Tests\MailSetTest::testSetValidEmailAsFrom
     * @covers  Lunr\Network\Mail::send
     */
    public function testSendReturnsFalseWhenSubjectIsEmpty()
    {
        $this->class->add_to('jobs@m2mobi.com');
        $this->class->set_from('info@m2mobi.com');

        $this->assertFalse($this->class->send());
    }

    /**
     * Test that send returns FALSE when sending fails.
     *
     * @depends  Lunr\Network\Tests\MailSetTest::testSetSubject
     * @depends  Lunr\Network\Tests\MailSetTest::testAddValidEmailAsTo
     * @depends  Lunr\Network\Tests\MailSetTest::testSetValidEmailAsFrom
     * @requires extension runkit
     * @covers   Lunr\Network\Mail::send
     */
    public function testSendReturnsFalseWhenSendingFails()
    {
        $this->class->set_subject('Subject');
        $this->class->add_to('jobs@m2mobi.com');
        $this->class->set_from('info@m2mobi.com');

        $this->mock_function('mail', self::SEND_MAIL_FAILS);

        $this->assertFalse($this->class->send());

        $this->unmock_function('mail');
    }

    /**
     * Test that send returns TRUE when sending works.
     *
     * @depends  Lunr\Network\Tests\MailSetTest::testSetSubject
     * @depends  Lunr\Network\Tests\MailSetTest::testAddValidEmailAsTo
     * @depends  Lunr\Network\Tests\MailSetTest::testSetValidEmailAsFrom
     * @requires extension runkit
     * @covers   Lunr\Network\Mail::send
     */
    public function testSendReturnsTrueWhenSendingSucceeds()
    {
        $this->class->set_subject('Subject');
        $this->class->add_to('jobs@m2mobi.com');
        $this->class->set_from('info@m2mobi.com');

        $this->mock_function('mail', self::SEND_MAIL_WORKS);

        $this->assertTrue($this->class->send());

        $this->unmock_function('mail');
    }

}

?>
