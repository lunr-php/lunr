<?php

/**
 * This file contains the HttpExceptionTest class.
 *
 * @package   Lunr\Corona\Exceptions
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018-2022, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Exceptions\Tests;

use Lunr\Corona\Exceptions\HttpException;
use Lunr\Halo\LunrBaseTest;
use Exception;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the HttpException class.
 *
 * @covers Lunr\Corona\Exceptions\HttpException
 */
abstract class HttpExceptionTest extends LunrBaseTest
{

    /**
     * Previous exception.
     * @var \Exception
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
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->message  = 'Http error!';
        $this->app_code = 9999;
        $this->code     = 400;

        $this->previous = new Exception();

        $this->class      = new HttpException($this->message, $this->code, $this->app_code, $this->previous);
        $this->reflection = new ReflectionClass('Lunr\Corona\Exceptions\HttpException');
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUpNoAppCode(): void
    {
        $this->message  = 'Http error!';
        $this->app_code = 0;
        $this->code     = 400;

        $this->previous = new Exception();

        $this->class      = new HttpException($this->message, $this->code, $this->app_code, $this->previous);
        $this->reflection = new ReflectionClass('Lunr\Corona\Exceptions\HttpException');
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
        unset($this->reflection);
        unset($this->class);
    }

}

?>
