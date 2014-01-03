<?php

/**
 * This file contains the MailTest class.
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

use Lunr\Network\Mail;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

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
abstract class MailTest extends LunrBaseTest
{

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
        $this->class      = new Mail();
        $this->reflection = new ReflectionClass('Lunr\Network\Mail');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Unit Test Data Provider for valid email addresses.
     *
     * @return array $base Array of email addresses
     */
    public function validEmailProvider()
    {
        $emails   = [];
        $emails[] = ['info@m2mobi.com'];
        $emails[] = ['info.jobs@m2mobi.com'];
        $emails[] = ['info-jobs@m2mobi.com'];
        $emails[] = ['INFO@m2mobi.com'];
        $emails[] = ['INFO@m2-mobi.com'];

        return $emails;
    }

    /**
     * Unit Test Data Provider for invalid email addresses.
     *
     * @return array $base Array of email addresses
     */
    public function invalidEmailProvider()
    {
        $emails   = [];
        $emails[] = [FALSE];
        $emails[] = [NULL];
        $emails[] = ['info'];
        $emails[] = [100];
        $emails[] = ['info@m2mobi'];

        return $emails;
    }

}

?>
