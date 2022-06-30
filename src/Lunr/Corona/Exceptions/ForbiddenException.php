<?php
/**
 * This file contains the ForbiddenException class.
 *
 * @package   Lunr\Corona\Exceptions
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Exceptions;

use \Lunr\Corona\HttpCode;
use \Exception;

/**
 * Exception for the Forbidden HTTP error (403).
 */
class ForbiddenException extends HttpException
{

    /**
     * Input data key.
     * @var string
     */
    protected $key;

    /**
     * Input data value
     * @var mixed
     */
    protected $value;

    /**
     * Constructor.
     */
    public function __construct($message = NULL, $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::FORBIDDEN, $app_code, $previous);

        $this->key   = NULL;
        $this->value = NULL;
    }

    /**
     * Set input data that caused the forbidden request.
     *
     * @param string $key   Key/URL parameter name
     * @param mixed  $value Input value
     *
     * @return void
     */
    public function setData(string $key, $value)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * Get the input data key.
     *
     * @return string Input data key
     */
    public function getDataKey(): string
    {
        return $this->key;
    }

    /**
     * Get the input data value.
     *
     * @return mixed Input data value
     */
    public function getDataValue()
    {
        return $this->value;
    }

    /**
     * Check whether input data was set or not.
     *
     * @return bool Input data was set or not.
     */
    public function isDataAvailable(): bool
    {
        return $this->key !== NULL;
    }

}

?>
