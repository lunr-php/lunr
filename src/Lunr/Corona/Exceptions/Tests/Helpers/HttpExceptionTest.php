<?php

/**
 * This file contains the HttpExceptionTest class.
 *
 * @package Lunr\Corona\Exceptions
 * @author  Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Corona\Exceptions\Tests\Helpers;

use Lunr\Halo\LunrBaseTest;
use Exception;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the HttpException class.
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
    protected $code;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        // Assumption: All HttpExceptions end in Exception.
        $name = str_replace('\\Tests\\', '\\', substr(static::class, 0, strrpos(static::class, 'Exception') + 9));

        $this->message = 'Http error!';
        $this->code    = 9999;

        $this->previous = new $name();

        $this->reflection = new ReflectionClass($name);
        $this->class      = new $name($this->message, $this->code, $this->previous);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->code);
        unset($this->message);
        unset($this->previous);
        unset($this->reflection);
        unset($this->class);
    }

}

?>
