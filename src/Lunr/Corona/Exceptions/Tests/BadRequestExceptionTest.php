<?php

/**
 * This file contains the BadRequestExceptionTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions\Tests;

use Exception;
use Lunr\Corona\Exceptions\BadRequestException;
use Lunr\Halo\LunrBaseTest;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the BadRequestException class.
 *
 * @covers Lunr\Corona\Exceptions\BadRequestException
 */
abstract class BadRequestExceptionTest extends LunrBaseTest
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
    protected $code;

    /**
     * Instance of the tested class.
     * @var BadRequestException
     */
    protected BadRequestException $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->message = 'Http error!';
        $this->code    = 9999;

        $this->previous = new Exception();

        $this->class = new BadRequestException($this->message, $this->code, $this->previous);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->code);
        unset($this->message);
        unset($this->previous);
        unset($this->class);

        parent::tearDown();
    }

}

?>
