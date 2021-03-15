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
     * Test that print_fatal_error() does not print an error page if there is no error.
     *
     * @requires extension msgpack
     *
     * @covers   Lunr\Corona\MsgpackView::print_fatal_error
     */
    public function testPrintFatalErrorPrintsNothingIfNoError(): void
    {
        $this->mock_function('error_get_last', fn() => NULL);

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
        $this->mock_function('error_get_last', fn() => [ 'type' => 8, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ]);

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
        $this->mock_function('error_get_last', fn() => [ 'type' => 1, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ]);
        $this->mock_function('header', '');

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_error.msgpack');

        $this->class->print_fatal_error();

        $this->unmock_function('error_get_last');
        $this->unmock_function('header');
    }

}

?>
