<?php

/**
 * This file contains the ConsoleLoggerTest class.
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

use Lunr\Feedback\ConsoleLogger;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the ConsoleLogger class.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Feedback\ConsoleLogger
 */
abstract class ConsoleLoggerTest extends LunrBaseTest
{

    /**
     * Mock instance of a Request class.
     * @var \Lunr\Corona\RequestInterface
     */
    protected $request;

    /**
     * Mock instance of the Console class.
     * @var \Lunr\Shadow\Console
     */
    protected $console;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->request = $this->getMock('Lunr\Corona\RequestInterface');
        $this->console = $this->getMockBuilder('Lunr\Shadow\Console')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class      = new ConsoleLogger($this->request, $this->console);
        $this->reflection = new ReflectionClass('Lunr\Feedback\ConsoleLogger');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->request);
        unset($this->console);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
