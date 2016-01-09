<?php

/**
 * This file contains the AbstractLoggerTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Feedback
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback\Tests;

use Lunr\Feedback\AbstractLogger;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the AbstractLogger class.
 *
 * @covers Lunr\Feedback\AbstractLogger
 */
abstract class AbstractLoggerTest extends LunrBaseTest
{

    /**
     * Mock instance of the Request class.
     * @var \Lunr\Corona\RequestInterface
     */
    protected $request;

    /**
     * Mock instance of the DateTime class
     * @var \Lunr\Core\DateTime
     */
    protected $datetime;

    /**
     * DateTime string used for Logging Output.
     * @var String
     */
    const DATETIME_STRING = '2011-11-10 10:30:22';

    /**
     * DateTime string used for Logging Output.
     * @var String
     */
    const DATETIME_LOG_STRING = '[2011-11-10 10:30:22]: ';

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpNoDateTime()
    {
        $this->request = $this->getMock('Lunr\Corona\RequestInterface');

        $this->class = $this->getMockBuilder('Lunr\Feedback\AbstractLogger')
                            ->setConstructorArgs([ $this->request ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Feedback\AbstractLogger');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpDateTime()
    {
        $this->request  = $this->getMock('Lunr\Corona\RequestInterface');
        $this->datetime = $this->getMock('Lunr\Core\DateTime');

        $this->datetime->expects($this->once())
                       ->method('set_datetime_format')
                       ->with($this->equalTo('%Y-%m-%d %H:%M:%S'));

        $this->class = $this->getMockBuilder('Lunr\Feedback\AbstractLogger')
                            ->setConstructorArgs([ $this->request, $this->datetime ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Feedback\AbstractLogger');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->request);
        unset($this->datetime);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit test data provider for log messages.
     *
     * @return array $messages Array of log messages
     */
    public function messageProvider()
    {
        $messages   = array();
        $messages[] = array('{test} msg', array('test' => 'value'), 'value msg');
        $messages[] = array('{test} msg, {test1}', array('test' => 'value', 'test1' => 1), 'value msg, 1');

        return $messages;
    }

}

?>
