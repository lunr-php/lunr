<?php

/**
 * This file contains the MailSendTest class.
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
 * This class contains test methods for sending emails.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Mail
 */
class MailSendTest extends MailTest
{

    /**
     * Test that generating carbon copy headers returns an empty string for invalid types.
     *
     * @covers Lunr\Libraries\Core\Mail::generate_carbon_copy_header
     */
    public function testGeneratingHeadersForInvalidCarbonCopyReturnsEmptyString()
    {
        $method = $this->mail_reflection->getMethod('generate_carbon_copy_header');
        $method->setAccessible(TRUE);

        $this->assertEquals('', $method->invokeArgs($this->mail, array('invalid')));
    }

    /**
     * Test that generating CC headers when none are defined returns an empty string.
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testCCEmptyByDefault
     * @covers  Lunr\Libraries\Core\Mail::generate_carbon_copy_header
     */
    public function testGeneratingCCHeadersWhenEmptyReturnsEmptyString()
    {
        $method = $this->mail_reflection->getMethod('generate_carbon_copy_header');
        $method->setAccessible(TRUE);

        $this->assertEquals('', $method->invokeArgs($this->mail, array('cc')));
        $this->assertEquals('', $method->invoke($this->mail));
    }

    /**
     * Test that generating BCC headers when none are defined returns an empty string.
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testBCCEmptyByDefault
     * @covers  Lunr\Libraries\Core\Mail::generate_carbon_copy_header
     */
    public function testGeneratingBCCHeadersWhenEmptyReturnsEmptyString()
    {
        $method = $this->mail_reflection->getMethod('generate_carbon_copy_header');
        $method->setAccessible(TRUE);

        $this->assertEquals('', $method->invokeArgs($this->mail, array('bcc')));
    }

    /**
     * Test generating CC headers with one entry.
     *
     * @covers  Lunr\Libraries\Core\Mail::generate_carbon_copy_header
     */
    public function testGeneratingCCHeadersWithOneEntry()
    {
        $method = $this->mail_reflection->getMethod('generate_carbon_copy_header');
        $method->setAccessible(TRUE);

        $property = $this->mail_reflection->getProperty('cc');
        $property->setAccessible(TRUE);

        $property->setValue($this->mail, array('info@m2mobi.com'));

        $expect = "CC: info@m2mobi.com\r\n";

        $this->assertEquals($expect, $method->invokeArgs($this->mail, array('cc')));
    }

    /**
     * Test generating CC headers with more than one entry.
     *
     * @covers  Lunr\Libraries\Core\Mail::generate_carbon_copy_header
     */
    public function testGeneratingCCHeadersWithMoreEntries()
    {
        $method = $this->mail_reflection->getMethod('generate_carbon_copy_header');
        $method->setAccessible(TRUE);

        $property = $this->mail_reflection->getProperty('cc');
        $property->setAccessible(TRUE);

        $property->setValue($this->mail, array('info@m2mobi.com', 'jobs@m2mobi.com'));

        $expect = "CC: info@m2mobi.com, jobs@m2mobi.com\r\n";

        $this->assertEquals($expect, $method->invokeArgs($this->mail, array('cc')));
    }

    /**
     * Test generating BCC headers with one entry.
     *
     * @covers  Lunr\Libraries\Core\Mail::generate_carbon_copy_header
     */
    public function testGeneratingBCCHeadersWithOneEntry()
    {
        $method = $this->mail_reflection->getMethod('generate_carbon_copy_header');
        $method->setAccessible(TRUE);

        $property = $this->mail_reflection->getProperty('bcc');
        $property->setAccessible(TRUE);

        $property->setValue($this->mail, array('info@m2mobi.com'));

        $expect = "BCC: info@m2mobi.com\r\n";

        $this->assertEquals($expect, $method->invokeArgs($this->mail, array('bcc')));
    }

    /**
     * Test generating BCC headers with more than one entry.
     *
     * @covers  Lunr\Libraries\Core\Mail::generate_carbon_copy_header
     */
    public function testGeneratingBCCHeadersWithMoreEntries()
    {
        $method = $this->mail_reflection->getMethod('generate_carbon_copy_header');
        $method->setAccessible(TRUE);

        $property = $this->mail_reflection->getProperty('bcc');
        $property->setAccessible(TRUE);

        $property->setValue($this->mail, array('info@m2mobi.com', 'jobs@m2mobi.com'));

        $expect = "BCC: info@m2mobi.com, jobs@m2mobi.com\r\n";

        $this->assertEquals($expect, $method->invokeArgs($this->mail, array('bcc')));
    }

    /**
     * Test that headers returns FALSE when there is no From address set.
     *
     * @depends Lunr\Libraries\Core\MailBaseTest::testFromEmptyByDefault
     * @covers  Lunr\Libraries\Core\Mail::generate_headers
     */
    public function testHeadersReturnsFalseWhenFromIsEmpty()
    {
        $method = $this->mail_reflection->getMethod('generate_headers');
        $method->setAccessible(TRUE);

        $this->assertFalse($method->invoke($this->mail));
    }

    /**
     * Test generating headers with neither CC nor BCC set.
     *
     * @depends testGeneratingCCHeadersWhenEmptyReturnsEmptyString
     * @depends testGeneratingBCCHeadersWhenEmptyReturnsEmptyString
     * @covers  Lunr\Libraries\Core\Mail::generate_headers
     */
    public function testHeadersWithEmptyCCAndEmptyBCC()
    {
        $method = $this->mail_reflection->getMethod('generate_headers');
        $method->setAccessible(TRUE);

        $property = $this->mail_reflection->getProperty('from');
        $property->setAccessible(TRUE);
        $property->setValue($this->mail, 'info@m2mobi.com');

        $expected  = "From: info@m2mobi.com\r\n";
        $expected .= 'X-Mailer: PHP/' . phpversion();

        $this->assertEquals($expected, $method->invoke($this->mail));
    }

    /**
     * Test generating headers with CC and without BCC.
     *
     * @depends testGeneratingCCHeadersWithOneEntry
     * @depends testGeneratingCCHeadersWithMoreEntries
     * @depends testGeneratingBCCHeadersWhenEmptyReturnsEmptyString
     * @covers  Lunr\Libraries\Core\Mail::generate_headers
     */
    public function testHeadersWithCCAndEmptyBCC()
    {
        $method = $this->mail_reflection->getMethod('generate_headers');
        $method->setAccessible(TRUE);

        $from = $this->mail_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->mail, 'info@m2mobi.com');

        $cc = $this->mail_reflection->getProperty('cc');
        $cc->setAccessible(TRUE);
        $cc->setValue($this->mail, array('jobs@m2mobi.com'));

        $expected  = "From: info@m2mobi.com\r\n";
        $expected .= "CC: jobs@m2mobi.com\r\n";
        $expected .= 'X-Mailer: PHP/' . phpversion();

        $this->assertEquals($expected, $method->invoke($this->mail));
    }

    /**
     * Test generating headers without CC and with BCC.
     *
     * @depends testGeneratingCCHeadersWhenEmptyReturnsEmptyString
     * @depends testGeneratingBCCHeadersWithOneEntry
     * @depends testGeneratingBCCHeadersWithMoreEntries
     * @covers  Lunr\Libraries\Core\Mail::generate_headers
     */
    public function testHeadersWithEmptyCCAndBCC()
    {
        $method = $this->mail_reflection->getMethod('generate_headers');
        $method->setAccessible(TRUE);

        $from = $this->mail_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->mail, 'info@m2mobi.com');

        $bcc = $this->mail_reflection->getProperty('bcc');
        $bcc->setAccessible(TRUE);
        $bcc->setValue($this->mail, array('jobs@m2mobi.com'));

        $expected  = "From: info@m2mobi.com\r\n";
        $expected .= "BCC: jobs@m2mobi.com\r\n";
        $expected .= 'X-Mailer: PHP/' . phpversion();

        $this->assertEquals($expected, $method->invoke($this->mail));
    }

    /**
     * Test generating headers with both CC and BCC set.
     *
     * @depends testGeneratingCCHeadersWithOneEntry
     * @depends testGeneratingCCHeadersWithMoreEntries
     * @depends testGeneratingBCCHeadersWithOneEntry
     * @depends testGeneratingBCCHeadersWithMoreEntries
     * @covers  Lunr\Libraries\Core\Mail::generate_headers
     */
    public function testHeaders()
    {
        $method = $this->mail_reflection->getMethod('generate_headers');
        $method->setAccessible(TRUE);

        $from = $this->mail_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->mail, 'info@m2mobi.com');

        $cc = $this->mail_reflection->getProperty('cc');
        $cc->setAccessible(TRUE);
        $cc->setValue($this->mail, array('jobs@m2mobi.com'));

        $bcc = $this->mail_reflection->getProperty('bcc');
        $bcc->setAccessible(TRUE);
        $bcc->setValue($this->mail, array('jobs@m2mobi.com'));

        $expected  = "From: info@m2mobi.com\r\n";
        $expected .= "CC: jobs@m2mobi.com\r\n";
        $expected .= "BCC: jobs@m2mobi.com\r\n";
        $expected .= 'X-Mailer: PHP/' . phpversion();

        $this->assertEquals($expected, $method->invoke($this->mail));
    }

    /**
     * Test sending fails when from is empty.
     *
     * @depends testHeadersReturnsFalseWhenFromIsEmpty
     * @depends Lunr\Libraries\Core\MailSetTest::testSetSubject
     * @depends Lunr\Libraries\Core\MailSetTest::testAddValidEmailAsTo
     * @covers  Lunr\Libraries\Core\Mail::send
     */
    public function testSendReturnsFalseWhenFromIsEmpty()
    {
        $this->mail->set_subject('Subject');
        $this->mail->add_to('jobs@m2mobi.com');

        $this->assertFalse($this->mail->send());
    }

    /**
     * Test sending fails when to is empty.
     *
     * @depends Lunr\Libraries\Core\MailSetTest::testSetSubject
     * @depends Lunr\Libraries\Core\MailSetTest::testSetValidEmailAsFrom
     * @covers  Lunr\Libraries\Core\Mail::send
     */
    public function testSendReturnsFalseWhenToIsEmpty()
    {
        $this->mail->set_subject('Subject');
        $this->mail->set_from('info@m2mobi.com');

        $this->assertFalse($this->mail->send());
    }

    /**
     * Test sending fails when to is empty.
     *
     * @depends Lunr\Libraries\Core\MailSetTest::testAddValidEmailAsTo
     * @depends Lunr\Libraries\Core\MailSetTest::testSetValidEmailAsFrom
     * @covers  Lunr\Libraries\Core\Mail::send
     */
    public function testSendReturnsFalseWhenSubjectIsEmpty()
    {
        $this->mail->add_to('jobs@m2mobi.com');
        $this->mail->set_from('info@m2mobi.com');

        $this->assertFalse($this->mail->send());
    }

    /**
     * Test that send returns FALSE when sending fails.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @depends Lunr\Libraries\Core\MailSetTest::testSetSubject
     * @depends Lunr\Libraries\Core\MailSetTest::testAddValidEmailAsTo
     * @depends Lunr\Libraries\Core\MailSetTest::testSetValidEmailAsFrom
     * @covers  Lunr\Libraries\Core\Mail::send
     */
    public function testSendReturnsFalseWhenSendingFails()
    {
        $this->mail->set_subject('Subject');
        $this->mail->add_to('jobs@m2mobi.com');
        $this->mail->set_from('info@m2mobi.com');

        runkit_function_redefine('mail', '', self::SEND_MAIL_FAILS);

        $this->assertFalse($this->mail->send());
    }

    /**
     * Test that send returns TRUE when sending works.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @depends Lunr\Libraries\Core\MailSetTest::testSetSubject
     * @depends Lunr\Libraries\Core\MailSetTest::testAddValidEmailAsTo
     * @depends Lunr\Libraries\Core\MailSetTest::testSetValidEmailAsFrom
     * @covers  Lunr\Libraries\Core\Mail::send
     */
    public function testSendReturnsTrueWhenSendingSucceeds()
    {
        $this->mail->set_subject('Subject');
        $this->mail->add_to('jobs@m2mobi.com');
        $this->mail->set_from('info@m2mobi.com');

        runkit_function_redefine('mail', '', self::SEND_MAIL_WORKS);

        $this->assertTrue($this->mail->send());
    }

}

?>
