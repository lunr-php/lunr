<?php

/**
 * This file contains the FileTimerTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Ticks\Tests;

use Lunr\Ticks\FileTimer;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Session class.
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Ticks\FileTimer
 */
abstract class FileTimerTest extends LunrBaseTest
{

    /**
     * Mock instance of the DateTime class.
     * @var DateTime
     */
    protected $datetime;

    /**
     * Mock instance of the SplFileObject class.
     * @var SplFileObject
     */
    protected $file;

    /**
     * Common testcase constructor parts.
     *
     * @return void
     */
    private function setUpCommon()
    {
        $this->reflection = new ReflectionClass('Lunr\Ticks\FileTimer');

        $this->file = $this->getMockBuilder('\SplFileObject')
                           ->setConstructorArgs([tempnam('/tmp', 'tick')])
                           ->getMock();

        $this->datetime = $this->getMock('Lunr\Core\DateTime');
        $this->datetime->expects($this->once())
                       ->method('set_datetime_format')
                       ->with('%Y-%m-%d %H:%M:%S');
    }

    /**
     * Test case constructor.
     */
    public function setUpNoRequest()
    {
        $this->setUpCommon();

        $request = $this->getMockBuilder('Lunr\Core\Request')
                        ->disableOriginalConstructor()
                        ->getMock();

        $request->expects($this->once())
                ->method('__get')
                ->will($this->returnValue(NULL));

        $this->class = new FileTimer($request, $this->datetime, $this->file);
    }

    /**
     * Test case constructor.
     */
    public function setUpRequest()
    {
        $this->setUpCommon();

        $request = $this->getMockBuilder('Lunr\Core\Request')
                        ->disableOriginalConstructor()
                        ->getMock();

        $request->expects($this->exactly(4))
                ->method('__get')
                ->will($this->returnArgument(0));

        $this->class = new FileTimer($request, $this->datetime, $this->file);
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->file);
        unset($this->datetime);
    }

    /**
     * Unit test data provider for single timer.
     *
     * @return array $timer Array of single timer information.
     */
    public function singleTimerProvider()
    {
        $data           = [];
        $data['single'] = [];

        $data['single']['start']   = 1371115612.4691;
        $data['single']['stop']    = 1372115612.4691;
        $data['single']['stopped'] = TRUE;
        $data['single']['tags']    = [ "tag1", "tag2" ];

        $timer   = [];
        $timer[] = [ $data, "Timer 'single': 1000000 µs; Tags: tag1,tag2\n" ];

        return $timer;
    }

    /**
     * Unit test data provider for multiple timers.
     *
     * @return array $timer Array of multiple timer information.
     */
    public function multipleTimerProvider()
    {
        $data     = [];
        $expected = [];

        for ($i = 0; $i < 2; $i++)
        {
            $data[$i] = [];

            $data[$i]['start']   = 1371115612.4691;
            $data[$i]['stop']    = 1372115612.4691;
            $data[$i]['stopped'] = TRUE;
            $data[$i]['tags']    = [ "tag1", "tag2" ];

            $expected[$i] = "Timer '$i': 1000000 µs; Tags: tag1,tag2\n";
        }

        $timer   = [];
        $timer[] = [$data, $expected];

        return $timer;
    }

    /**
     * Unit test data provider for Tags.
     *
     * @return Array tags Array of tags.
     */
    public function tagsProvider()
    {
        $tags   = [];
        $tags[] = [['tag1'], ['tag2'], ['tag1', 'tag2']];
        $tags[] = [[], ['tag1', 'tag2'], ['tag1', 'tag2']];
        $tags[] = [['tag1', 'tag2'], [], ['tag1', 'tag2']];
        $tags[] = [['tag1', 'tag2'], ['tag2', 'tag3'], ['tag1', 'tag2', 3 => 'tag3']];

        return $tags;
    }
}

?>
