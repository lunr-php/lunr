<?php

/**
 * This file contains the ConsoleTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

use Lunr\Shadow\Console;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the Console class.
 *
 * @covers Lunr\Shadow\Console
 */
class ConsoleTest extends LunrBaseTest
{

    /**
     * DateTime string used for Console Output.
     * @var String
     */
    private const DATETIME_STRING = '2011-11-10 09:11:22';

    /**
     * Shared time for the test.
     *
     * @var \DateTimeImmutable
     */
    private $datetime;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->datetime   = $this->getMockBuilder('DateTime')
                                 ->getMock();
        $this->class      = new Console($this->datetime);
        $this->reflection = new ReflectionClass('Lunr\Shadow\Console');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Test the building of an output string.
     *
     * @covers Lunr\Shadow\Console::build_cli_output
     */
    public function testBuildCliOutput(): void
    {
        $this->datetime->expects($this->once())
                       ->method('setTimestamp')
                       ->will($this->returnSelf());
        $this->datetime->expects($this->once())
                       ->method('format')
                       ->with('Y-m-d H:m:s')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $method = $this->get_accessible_reflection_method('build_cli_output');
        $msg    = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg;
        $this->assertEquals($output, $method->invokeArgs($this->class, [ $msg ]));
    }

    /**
     * Test the normal output of a string.
     *
     * @covers Lunr\Shadow\Console::cli_print
     */
    public function testCliPrint(): void
    {
        $this->datetime->expects($this->once())
                       ->method('setTimestamp')
                       ->will($this->returnSelf());
        $this->datetime->expects($this->once())
                       ->method('format')
                       ->with('Y-m-d H:m:s')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $msg    = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg;

        $this->expectOutputString($output);
        $this->class->cli_print($msg);
    }

    /**
     * Test the output of a string with a linebreak at the end.
     *
     * @covers Lunr\Shadow\Console::cli_println
     */
    public function testCliPrintln(): void
    {
        $this->datetime->expects($this->once())
                       ->method('setTimestamp')
                       ->will($this->returnSelf());
        $this->datetime->expects($this->once())
                       ->method('format')
                       ->with('Y-m-d H:m:s')
                       ->will($this->returnValue(self::DATETIME_STRING));

        $msg    = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg . "\n";

        $this->expectOutputString($output);
        $this->class->cli_println($msg);
    }

    /**
     * Test the output of a string with a linebreak at the end.
     *
     * @covers Lunr\Shadow\Console::cli_println
     */
    public function testCliPrintlnCustomFormat(): void
    {
        $this->datetime->expects($this->once())
                       ->method('setTimestamp')
                       ->will($this->returnSelf());
        $this->datetime->expects($this->once())
                       ->method('format')
                       ->with('c')
                       ->will($this->returnValue('2011-11-10T09:30:22+00:00'));

        $class = new Console($this->datetime, 'c');

        $msg    = 'Test';
        $output = '2011-11-10T09:30:22+00:00: ' . $msg . "\n";

        $this->expectOutputString($output);
        $class->cli_println($msg);
    }

    /**
     * Test printing an ok status.
     *
     * @covers Lunr\Shadow\Console::cli_print_status
     */
    public function testCliPrintStatusOK(): void
    {
        $output = "[ok]\n";

        $this->expectOutputString($output);
        $this->class->cli_print_status(TRUE);
    }

    /**
     * Test printing a failed status.
     *
     * @covers Lunr\Shadow\Console::cli_print_status
     */
    public function testCliPrintStatusFailed(): void
    {
        $output = "[failed]\n";

        $this->expectOutputString($output);
        $this->class->cli_print_status(FALSE);
    }

}

?>
