<?php

/**
 * This file contains the ConsoleTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

use Lunr\Shadow\Console;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the Console class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Shadow\Console
 */
class ConsoleTest extends LunrBaseTest
{

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

        $this->class = new Console($datetime);

        $this->reflection = new ReflectionClass('Lunr\Shadow\Console');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Test the building of an output string.
     *
     * @covers Lunr\Shadow\Console::build_cli_output
     */
    public function testBuildCliOutput()
    {
        $method = $this->get_accessible_reflection_method('build_cli_output');
        $msg    = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg;
        $this->assertEquals($output, $method->invokeArgs($this->class, array($msg)));
    }

    /**
     * Test the normal output of a string.
     *
     * @covers Lunr\Shadow\Console::cli_print
     */
    public function testCliPrint()
    {
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
    public function testCliPrintln()
    {
        $msg    = 'Test';
        $output = self::DATETIME_STRING . ': ' . $msg . "\n";

        $this->expectOutputString($output);
        $this->class->cli_println($msg);
    }

    /**
     * Test printing an ok status.
     *
     * @covers Lunr\Shadow\Console::cli_print_status
     */
    public function testCliPrintStatusOK()
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
    public function testCliPrintStatusFailed()
    {
        $output = "[failed]\n";

        $this->expectOutputString($output);
        $this->class->cli_print_status(FALSE);
    }

}

?>
