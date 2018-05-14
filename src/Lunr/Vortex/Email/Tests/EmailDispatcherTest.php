<?php

/**
 * This file contains the EmailDispatcherTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Vortex\Email\EmailDispatcher;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the EmailDispatcher class.
 *
 * @covers Lunr\Vortex\Email\EmailDispatcher
 */
abstract class EmailDispatcherTest extends LunrBaseTest
{
    /**
     * Mock instance of the PHPMailer class.
     * @var \PHPMailer\PHPMailer\PHPMailer
     */
    protected $mail_transport;

    /**
     * Mock instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Email Payload class.
     * @var EmailPayload
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->mail_transport = $this->getMockBuilder('PHPMailer\PHPMailer\PHPMailer')->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->payload = $this->getMockBuilder('Lunr\Vortex\Email\EmailPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new EmailDispatcher($this->mail_transport, $this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\Email\EmailDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->mail_transport);
        unset($this->payload);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
