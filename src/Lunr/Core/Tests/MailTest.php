<?php

/**
 * This file contains the MailTest class.
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

namespace Lunr\Core\Tests;

use Lunr\Core\Mail;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the Mail class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\Mail
 */
abstract class MailTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Mail class.
     * @var Mail
     */
    protected $mail;

    /**
     * Reflection instance of the Mail class.
     * @var ReflectionClass
     */
    protected $mail_reflection;

    /**
     * Runkit simulation code for working email sending.
     * @var string
     */
    const SEND_MAIL_WORKS = 'return TRUE;';

    /**
     * Runkit simulation code for failing email sending.
     * @var string
     */
    const SEND_MAIL_FAILS = 'return FALSE;';

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->mail            = new Mail();
        $this->mail_reflection = new ReflectionClass('Lunr\Core\Mail');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->mail);
        unset($this->mail_reflection);
    }

    /**
     * Unit Test Data Provider for valid email addresses.
     *
     * @return array $base Array of email addresses
     */
    public function validEmailProvider()
    {
        $emails   = array();
        $emails[] = array('info@m2mobi.com');
        $emails[] = array('info.jobs@m2mobi.com');
        $emails[] = array('info-jobs@m2mobi.com');
        $emails[] = array('INFO@m2mobi.com');
        $emails[] = array('INFO@m2-mobi.com');

        return $emails;
    }

    /**
     * Unit Test Data Provider for invalid email addresses.
     *
     * @return array $base Array of email addresses
     */
    public function invalidEmailProvider()
    {
        $emails   = array();
        $emails[] = array(FALSE);
        $emails[] = array(NULL);
        $emails[] = array('info');
        $emails[] = array(100);
        $emails[] = array('info@m2mobi');

        return $emails;
    }

}

?>
