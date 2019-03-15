<?php

/**
 * This file contains the EmailResponseTest class.
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Vortex\Email\EmailResponse;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains setup routines for testing the EmailResponse class.
 *
 * @covers Lunr\Vortex\Email\EmailResponse
 */
abstract class EmailResponseTest extends LunrBaseTest
{

    /**
     * Instance of the EmailResponse class.
     * @var EmailResponse
     */
    protected $class;

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Instance of the ReflectionClass class.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->class      = new EmailResponse([], $this->logger);
        $this->reflection = new ReflectionClass('Lunr\Vortex\Email\EmailResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpError()
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = $this->getMockBuilder('PHPMailer\PHPMailer\PHPMailer')->getMock();

        $response->expects($this->once())
                 ->method('isError')
                 ->will($this->returnValue(TRUE));

        $response->ErrorInfo = 'ErrorInfo';

        $mail_results = [
            'error-endpoint' => [
                'is_error'      => $response->isError(),
                'error_message' => $response->ErrorInfo
            ]
        ];

        $this->logger->expects($this->once())
             ->method('warning')
             ->with(
               $this->equalTo('Sending email notification to {endpoint} failed: {message}'),
               $this->equalTo([ 'endpoint' => 'error-endpoint', 'message' => 'ErrorInfo' ])
             );

        $this->class      = new EmailResponse($mail_results, $this->logger);
        $this->reflection = new ReflectionClass('Lunr\Vortex\Email\EmailResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpSuccess(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = $this->getMockBuilder('PHPMailer\PHPMailer\PHPMailer')->getMock();

        $response->expects($this->once())
                 ->method('isError')
                 ->will($this->returnValue(FALSE));

        $mail_results = [
            'success-endpoint' => [
                'is_error'      => $response->isError(),
                'error_message' => $response->ErrorInfo
            ]
        ];

        $this->class      = new EmailResponse($mail_results, $this->logger);
        $this->reflection = new ReflectionClass('Lunr\Vortex\Email\EmailResponse');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

}
