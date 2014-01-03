<?php

/**
 * This file contains the ChainLoggerTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback\Tests;

use Lunr\Feedback\ChainLogger;
use Psr\Log\LogLevel;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the ChainLogger class.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Feedback\ChainLogger
 */
abstract class ChainLoggerTest extends LunrBaseTest
{

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger1;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger2;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->logger1 = $this->getMock('Psr\Log\LoggerInterface');
        $this->logger2 = $this->getMock('Psr\Log\LoggerInterface');

        $this->class      = new ChainLogger($this->logger1, $this->logger2);
        $this->reflection = new ReflectionClass('Lunr\Feedback\ChainLogger');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger1);
        unset($this->logger2);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
