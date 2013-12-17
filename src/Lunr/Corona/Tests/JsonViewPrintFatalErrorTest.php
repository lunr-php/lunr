<?php

/**
 * This file contains the JsonViewPrintFatalErrorTest class.
 *
 * PHP Version 5.4
 *
 * @category   Library
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the JsonView class.
 *
 * @category   Library
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\JsonView
 */
class JsonViewPrintFatalErrorTest extends JsonViewTest
{

    /**
     * Runkit simulation code for no error.
     * @var String
     */
    const NO_ERROR = "return NULL;";

    /**
     * Runkit simulation code for non-fatal error.
     * @var String
     */
    const ERROR = "return [ 'type' => 8, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ];";

    /**
     * Runkit simulation code for a fatal error.
     * @var String
     */
    const FATAL_ERROR = "return [ 'type' => 1, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ];";

    /**
     * Test that print_fatal_error() does not print an error page if there is no error.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\JsonView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsNothingIfNoError()
    {
        $this->mock_function('error_get_last', self::NO_ERROR);

        $this->expectOutputString("");

        $this->class->print_fatal_error();

        $this->unmock_function('error_get_last');
    }

    /**
     * Test that print_fatal_error() does not print an error page if there is no fatal error.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\JsonView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsNothingIfErrorNotFatal()
    {
        $this->mock_function('error_get_last', self::ERROR);

        $this->expectOutputString("");

        $this->class->print_fatal_error();

        $this->unmock_function('error_get_last');
    }

    /**
     * Test that print_fatal_error() does prints a json object if there is a fatal error.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\JsonView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsPrettyJson()
    {
        $this->mock_function('error_get_last', self::FATAL_ERROR);
        $this->mock_function('header', '');

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_error.json');

        $this->class->print_fatal_error();

        $this->unmock_function('error_get_last');
        $this->unmock_function('header');
    }

    /**
     * Test that print_fatal_error() does prints a json object if there is a fatal error.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\JsonView::print_fatal_error
     */
    public function testPrintFatalErrorForWebPrintsJson()
    {
        $this->mock_function('error_get_last', self::FATAL_ERROR);
        $this->mock_function('header', '');

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('web'));

        $this->expectOutputString('{"data":{},"status":{"code":500,"message":"Message in index.php on line 2"}}');

        $this->class->print_fatal_error();

        $this->unmock_function('error_get_last');
        $this->unmock_function('header');
    }

}

?>
