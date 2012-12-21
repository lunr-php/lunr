<?php

/**
 * This file contains the ConsoleTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\Console;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the Console class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\Console
 */
class ConsoleTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Console class.
     * @var Console
     */
    private $console;

    /**
     * Reflection instance of the Console class.
     * @var ReflectionClass
     */
    private $console_reflection;

    /**
     * DateTime string used for Console Output.
     * @var String
     */
    const DATETIME_STRING = '2011-11-10 10:30:22';

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $datetime = $this->getMock('Lunr\Core\DateTime');
        $datetime->expects($this->once())
                 ->method('set_datetime_format')
                 ->will($this->returnValue(TRUE));
        $datetime->expects($this->any())
                 ->method('get_datetime')
                 ->will($this->returnValue(self::DATETIME_STRING));

        $this->console = new Console($datetime);

        $this->console_reflection = new ReflectionClass('Lunr\Core\Console');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->console);
        unset($this->console_reflection);
    }

    /**
     * Test the building of an output string.
     *
     * @covers Lunr\Core\Console::build_cli_output
     */
    public function testBuildCliOutput()
    {
        $method = $this->console_reflection->getMethod('build_cli_output');
        $method->setAccessible(TRUE);
        $msg    = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg;
        $this->assertEquals($output, $method->invokeArgs($this->console, array($msg)));
    }

    /**
     * Test the normal output of a string.
     *
     * @covers Lunr\Core\Console::cli_print
     */
    public function testCliPrint()
    {
        $msg    = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg;

        $this->expectOutputString($output);
        $this->console->cli_print($msg);
    }

    /**
     * Test the output of a string with a linebreak at the end.
     *
     * @covers Lunr\Core\Console::cli_println
     */
    public function testCliPrintln()
    {
        $msg    = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg . "\n";

        $this->expectOutputString($output);
        $this->console->cli_println($msg);
    }

    /**
     * Test printing an ok status.
     *
     * @covers Lunr\Core\Console::cli_print_status
     */
    public function testCliPrintStatusOK()
    {
        $output = "[ok]\n";

        $this->expectOutputString($output);
        $this->console->cli_print_status(TRUE);
    }

    /**
     * Test printing a failed status.
     *
     * @covers Lunr\Core\Console::cli_print_status
     */
    public function testCliPrintStatusFailed()
    {
        $output = "[failed]\n";

        $this->expectOutputString($output);
        $this->console->cli_print_status(FALSE);
    }

}

?>
