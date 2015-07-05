<?php

/**
 * This file contains the EmailDispatcherTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Vortex\Email\EmailDispatcher;
// use Lunr\Vortex\Email\EmailPriority;
// use Lunr\Vortex\Email\EmailType;
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
     * Mock instance of the Mail class.
     * @var Mail
     */
    protected $mail;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Reflection instance of the EmailDispatcher
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->mail   = $this->getMock('Lunr\Network\Mail');
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->class = new EmailDispatcher($this->mail, $this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\Email\EmailDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->mail);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
