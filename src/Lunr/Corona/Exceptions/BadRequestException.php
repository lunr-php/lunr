<?php
/**
 * This file contains the BadRequestException class.
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
     * Report data
     * @var string
     */
    protected $report;

    /**
     * Whether input data was set or not.
     * @var boolean
     */
    protected $dataAvailable;

    /**
     * Whether a detailed input data report was set or not.
     * @var boolean
     */
    protected $reportAvailable;

    /**
     * Constructor.
     */
    public function __construct($message = NULL, $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::BAD_REQUEST, $app_code, $previous);

        $this->key    = NULL;
        $this->value  = NULL;
        $this->report = NULL;

        $this->dataAvailable   = FALSE;
        $this->reportAvailable = FALSE;
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
     * Set report data about the bad request.
     *
     * @param string $data Report data
     *
     * @return void
     */
    public function setReport($data)
    {
        if (empty($data))
        {
            return;
        }

        $this->report = $data;

        $this->reportAvailable = TRUE;
    }

    /**
     * Set report data about the bad request.
     *
     * @param array $failures Failure messages per key
     *
     * @return void
     */
    public function setArrayReport($failures)
    {
        if (empty($failures))
        {
            return;
        }

        $this->report = '';

        foreach ($failures as $key => $messages)
        {
            foreach ($messages as $message)
            {
                $this->report .= "$key: $message\n";
            }
        }

        $this->reportAvailable = TRUE;
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
     * Get the detailed input data report.
     *
     * @return string Detailed input data report
     */
    public function getReport()
    {
        return $this->report;
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

    /**
     * Check whether a detailed input data report was set or not.
     *
     * @return boolean Input data report was set or not.
     */
    public function isReportAvailable()
    {
        return $this->reportAvailable;
    }

}

?>
