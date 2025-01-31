<?php

/**
 * This file contains the RequestedRangeNotSatisfiableExceptionTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions\Tests;

use Exception;
use Lunr\Corona\Exceptions\RequestedRangeNotSatisfiableException;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the RequestedRangeNotSatisfiableException class.
 *
 * @covers Lunr\Corona\Exceptions\RequestedRangeNotSatisfiableException
 */
abstract class RequestedRangeNotSatisfiableExceptionTestCase extends LunrBaseTestCase
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
     * @var RequestedRangeNotSatisfiableException
     */
    protected RequestedRangeNotSatisfiableException $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->message = 'Http error!';
        $this->code    = 9999;

        $this->previous = new Exception();

        $this->class = new RequestedRangeNotSatisfiableException($this->message, $this->code, $this->previous);

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
