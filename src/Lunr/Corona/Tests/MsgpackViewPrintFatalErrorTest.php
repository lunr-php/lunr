<?php

/**
 * This file contains the MsgpackViewPrintFatalErrorTest class.
 *
 * @package   Lunr\Corona
 * @author    Patrick Valk <p.valk@m2mobi.com>
 * @copyright 2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the MsgpackView class.
 *
 * @covers     Lunr\Corona\MsgpackView
 */
class MsgpackViewPrintFatalErrorTest extends MsgpackViewTest
{

    /**
     * Runkit simulation code for no error.
     * @var String
     */
    const NO_ERROR = 'return NULL;';

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
     * @requires extension msgpack
     *
     * @covers   Lunr\Corona\MsgpackView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsNothingIfNoError(): void
    {
        $this->mock_function('error_get_last', self::NO_ERROR);

        $this->expectOutputString('');

        $this->class->print_fatal_error();

        $this->unmock_function('error_get_last');
    }

    /**
     * Test that print_fatal_error() does not print an error page if there is no fatal error.
     *
     * @requires extension msgpack
     *
     * @covers   Lunr\Corona\MsgpackView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsNothingIfErrorNotFatal(): void
    {
        $this->mock_function('error_get_last', self::ERROR);

        $this->expectOutputString('');

        $this->class->print_fatal_error();

        $this->unmock_function('error_get_last');
    }

    /**
     * Test that print_fatal_error() does prints a msgpack object if there is a fatal error.
     *
     * @requires extension msgpack
     *
     * @covers   Lunr\Corona\MsgpackView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsMsgpack(): void
    {
        $this->mock_function('error_get_last', self::FATAL_ERROR);
        $this->mock_function('header', '');

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_error.msgpack');

        $this->class->print_fatal_error();

        $this->unmock_function('error_get_last');
        $this->unmock_function('header');
    }

}

?>
