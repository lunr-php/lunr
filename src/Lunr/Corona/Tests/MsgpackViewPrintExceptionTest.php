<?php

/**
 * This file contains the MsgpackViewPrintExceptionTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Tests\Helpers\MockUncaughtException;

/**
 * This class contains tests for the MsgpackView class.
 *
 * @covers Lunr\Corona\MsgpackView
 */
class MsgpackViewPrintExceptionTest extends MsgpackViewTest
{

    /**
     * Test that print_exception() prints a msgpack object if there is an exception.
     *
     * @requires extension msgpack
     * @covers   Lunr\Corona\MsgpackView::print_exception
     */
    public function testPrintExceptionPrintsMsgpack(): void
    {
        $exception = new MockUncaughtException('Message');

        $exception->setFile('index.php');
        $exception->setLine(100);

        $this->mock_function('header', function () {});
        $this->mock_function('http_response_code', function () {});

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_exception.msgpack');

        $this->class->print_exception($exception);

        $this->unmock_function('header');
        $this->unmock_function('http_response_code');
    }

}

?>
