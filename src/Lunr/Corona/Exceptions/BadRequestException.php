<?php
/**
 * This file contains the BadRequestException class.
 *
 * PHP Version 7.0
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
 * Exception for the Bad Request HTTP error (400).
 */
class BadRequestException extends HttpException
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
     * Whether input data was set or not.
     * @var boolean
     */
    protected $dataAvailable;

    /**
     * Constructor.
     */
    public function __construct($message = NULL, $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::BAD_REQUEST, $app_code, $previous);

        $this->key   = NULL;
        $this->value = NULL;

        $this->dataAvailable = FALSE;
    }

    /**
     * Set input data that caused the bad request.
     *
     * @param string $key   Key/URL parameter name
     * @param mixed  $value Input value
     *
     * @return void
     */
    public function setData($key, $value)
    {
        $this->key   = $key;
        $this->value = $value;

        $this->dataAvailable = TRUE;
    }

    /**
     * Get the input data key.
     *
     * @return string Input data key
     */
    public function getDataKey()
    {
        return $this->key;
    }

    /**
     * Get the input data value.
     *
     * @return string Input data value
     */
    public function getDataValue()
    {
        return $this->value;
    }

    /**
     * Check whether input data was set or not.
     *
     * @return boolean Input data was set or not.
     */
    public function isDataAvailable()
    {
        return $this->dataAvailable;
    }

}

?>
