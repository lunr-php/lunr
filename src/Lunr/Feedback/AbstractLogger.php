<?php

/**
 * Abstract Logger implementing log message composition
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Feedback
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback;

/**
 * Abstract class implementing parts of the PSR-3 standard.
 */
abstract class AbstractLogger extends PSR3Logger
{

    /**
     * Reference to the Request class.
     * @var \Lunr\Corona\RequestInterface
     */
    protected $request;

    /**
     * Instance of a DateTime class
     * @var \Lunr\Core\DateTime
     */
    protected $datetime;

    /**
     * Constructor.
     *
     * @param \Lunr\Corona\RequestInterface $request  Reference to the Request class.
     * @param \Lunr\Core\DateTime           $datetime Instance of the DateTime class.
     */
    public function __construct($request, $datetime = NULL)
    {
        $this->request  = $request;
        $this->datetime = $datetime;

        if ($this->datetime !== NULL)
        {
            $this->datetime->set_datetime_format('%Y-%m-%d %H:%M:%S');
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->datetime);
    }

    /**
     * Compose a timestamped message string.
     *
     * @param String $message Base message with placeholders
     * @param array  $context Additional meta-information for the log
     *
     * @return String $msg Log Message String
     */
    protected function compose_timestamped_message($message, $context)
    {
        $prefix = '';

        if ($this->datetime !== NULL)
        {
            $prefix .= '[' . $this->datetime->get_datetime() . ']: ';
        }

        return $prefix . $this->compose_message($message, $context);
    }

    /**
     * Compose message string.
     *
     * @param String $message Base message with placeholders
     * @param array  $context Additional meta-information for the log
     *
     * @return String $msg Log Message String
     */
    protected function compose_message($message, $context)
    {
        $suffix = $infix = '';

        if ($this->request->call !== NULL)
        {
            $infix .= $this->request->call . ': ';
        }

        if (!empty($context['file']) && !empty($context['line']))
        {
            $suffix .= ' (' . $context['file'] . ': ' . $context['line'] . ')';
        }

        return $infix . $this->interpolate_message($message, $context) . $suffix;
    }

    /**
     * Replace placeholders in log message according to PSR-3.
     *
     * @param String $message Base message with placeholders
     * @param array  $context Additional meta-information for the log
     *
     * @return String $message Interpolated message
     */
    protected function interpolate_message($message, $context)
    {
        $replace = [];

        foreach ($context as $key => $val)
        {
            $replace['{' . $key . '}'] = $val;
        }

        return strtr($message, $replace);
    }

}

?>
