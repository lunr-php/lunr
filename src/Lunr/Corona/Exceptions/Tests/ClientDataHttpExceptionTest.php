<?php

/**
 * This file contains the ClientDataHttpExceptionTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions\Tests;

use Exception;
use Lunr\Corona\Exceptions\ClientDataHttpException;
use Lunr\Halo\LunrBaseTest;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the HttpException class.
 *
 * @covers Lunr\Corona\Exceptions\HttpException
 */
abstract class ClientDataHttpExceptionTest extends LunrBaseTest
{

    /**
     * Previous exception.
     * @var Exception
     */
    protected $previous;

    /**
     * Error message.
     * @var string
     */
    protected $message;

    /**
     * Application error code.
     * @var int
     */
    protected $app_code;

    /**
     * HTTP error code.
     * @var int
     */
    protected $code;

    /**
     * Instance of the tested class.
     * @var ClientDataHttpException
     */
    protected ClientDataHttpException $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->message  = 'Http error!';
        $this->app_code = 9999;
        $this->code     = 400;

        $this->previous = new Exception();

        $this->class = $this->getMockBuilder(ClientDataHttpException::class)
                            ->setConstructorArgs([ $this->message, $this->code, $this->app_code, $this->previous ])
                            ->getMockForAbstractClass();

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->code);
        unset($this->app_code);
        unset($this->message);
        unset($this->previous);
        unset($this->class);

        parent::tearDown();
    }

}

?>
