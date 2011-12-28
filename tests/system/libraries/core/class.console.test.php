<?php

/**
 * This file contains the ConsoleTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the Console class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Console
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
        $datetime = $this->getMock('Lunr\Libraries\Core\DateTime');
        $datetime->expects($this->once())
                 ->method('set_datetime_format')
                 ->will($this->returnValue(TRUE));
        $datetime->expects($this->any())
                 ->method('get_datetime')
                 ->will($this->returnValue(self::DATETIME_STRING));

        $this->console = new Console($datetime);

        $this->console_reflection = new ReflectionClass("Lunr\Libraries\Core\Console");
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
     * @covers Lunr\Libraries\Core\Console::build_cli_output
     */
    public function testBuildCliOutput()
    {
        $method = $this->console_reflection->getMethod('build_cli_output');
        $method->setAccessible(TRUE);
        $msg = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg;
        $this->assertEquals($output, $method->invokeArgs($this->console, array($msg)));
    }

    /**
     * Test the normal output of a string.
     *
     * @covers Lunr\Libraries\Core\Console::cli_print
     */
    public function testCliPrint()
    {
        $msg = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg;

        ob_start();
        $this->console->cli_print($msg);
        $return = ob_get_clean();

        $this->assertEquals($output, $return);
    }

    /**
     * Test the output of a string with a linebreak at the end.
     *
     * @covers Lunr\Libraries\Core\Console::cli_println
     */
    public function testCliPrintln()
    {
        $msg = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg . "\n";

        ob_start();
        $this->console->cli_println($msg);
        $return = ob_get_clean();

        $this->assertEquals($output, $return);
    }

    /**
     * Test printing an ok status.
     *
     * @covers Lunr\Libraries\Core\Console::cli_print_status
     */
    public function testCliPrintStatusOK()
    {
        $output = "[ok]\n";

        ob_start();
        $this->console->cli_print_status(TRUE);
        $return = ob_get_clean();

        $this->assertEquals($output, $return);
    }

    /**
     * Test printing a failed status.
     *
     * @covers Lunr\Libraries\Core\Console::cli_print_status
     */
    public function testCliPrintStatusFailed()
    {
        $output = "[failed]\n";

        ob_start();
        $this->console->cli_print_status(FALSE);
        $return = ob_get_clean();

        $this->assertEquals($output, $return);
    }

}

?>
