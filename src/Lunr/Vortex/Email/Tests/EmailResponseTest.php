<?php

/**
 * This file contains the EmailResponseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Vortex\Email\EmailResponse;
use Lunr\Vortex\PushNotificationStatus;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the EmailResponse class.
 *
 * @covers Lunr\Vortex\Email\EmailResponse
 */
abstract class EmailResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpError()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMock('PHPMailer\PHPMailer\PHPMailer');

        $response->expects($this->once())
                 ->method('isError')
                 ->will($this->returnValue(TRUE));

        $response->ErrorInfo = 'ErrorInfo';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        $this->equalTo('Sending email notification to {endpoint} failed: {message}'),
                        $this->equalTo([ 'endpoint' => '12345679', 'message' => 'ErrorInfo' ])
                     );

        $this->class      = new EmailResponse($response, $this->logger, '12345679');
        $this->reflection = new ReflectionClass('Lunr\Vortex\Email\EmailResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpSuccess()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMock('PHPMailer\PHPMailer\PHPMailer');

        $response->expects($this->once())
                 ->method('isError')
                 ->will($this->returnValue(FALSE));

        $this->class      = new EmailResponse($response, $this->logger, '12345679');
        $this->reflection = new ReflectionClass('Lunr\Vortex\Email\EmailResponse');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

}
