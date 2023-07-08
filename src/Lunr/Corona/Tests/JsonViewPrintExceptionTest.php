<?php

/**
 * This file contains the JsonViewPrintExceptionTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Tests\Helpers\MockUncaughtException;

/**
 * This class contains tests for the JsonView class.
 *
 * @covers Lunr\Corona\JsonView
 */
class JsonViewPrintExceptionTest extends JsonViewTest
{

    /**
     * Test that print_exception() prints a json object if there is an exception.
     *
     * @requires PHP 5.5.12
     * @covers   Lunr\Corona\JsonView::print_exception
     */
    public function testPrintExceptionPrintsPrettyJson(): void
    {
        $exception = new MockUncaughtException('Message');

        $exception->setFile('index.php');
        $exception->setLine(100);

        $this->mock_function('header', function (){});

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('sapi')
                      ->willReturn('cli');

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_exception.json');

        $this->class->print_exception($exception);

        $this->unmock_function('header');
    }

    /**
     * Test that print_exception() prints a json object if there is an exception.
     *
     * @covers   Lunr\Corona\JsonView::print_exception
     */
    public function testPrintExceptionForWebPrintsJson(): void
    {
        $exception = new MockUncaughtException('Message');

        $exception->setFile('index.php');
        $exception->setLine(100);

        $this->mock_function('header', function (){});

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('sapi')
                      ->willReturn('web');

        $message  = '{"data":{},"status":{"code":500,"message":"Uncaught Exception ';
        $message .= 'Lunr\\\\Corona\\\\Tests\\\\Helpers\\\\MockUncaughtException';
        $message .= ': \"Message\" at index.php line 100"}}';

        $this->expectOutputString($message);

        $this->class->print_exception($exception);

        $this->unmock_function('header');
    }

}

?>
