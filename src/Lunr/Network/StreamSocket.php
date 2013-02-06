<?php

/**
 * This file contains an abstract stream socket wrapper class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network;

/**
 * abstract stream socket wrapper class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
abstract class StreamSocket
{

    use NetworkErrorTrait;

    /**
     * Stream socket context options array
     * @var array
     */
    protected $context_options;

    /**
     * Stream socket context
     * @var resource
     */
    protected $context;

    /**
     * Stream socket resource handle
     * @var resource
     */
    protected $handle;

    /**
     * Informations about the request
     * @var array
     */
    protected $meta_data;

    /**
     * Blocking mode of the stream
     * @var Boolean
     */
    protected $blocking;

    /**
     * Notification callback function name
     * @var Callable
     */
    protected $notification;

    /**
     * flag values for the stream creation
     * @var array
     */
    protected $flags;

    /**
     * Time out for read/write transactions in seconds.
     * @var Integer
     */
    protected $timeout_seconds;

    /**
     * Time out for read/write transactions in microseconds.
     * @var Integer
     */
    protected $timeout_microseconds;

    /**
     * Conctructor.
     */
    public function __construct()
    {
        $this->context_options = array();

        // default: no error
        $this->error_number  = 0;
        $this->error_message = '';

        // default no callback function
        $this->notification = NULL;

        // default: no meta_data
        $this->meta_data = array();
        // flags are empty as from abstract class
        $this->flags = array();

        // pre-initialization
        $this->handle  = NULL;
        $this->context = NULL;

        // default blocking stream
        $this->blocking = TRUE;

        // default stream timeout
        $this->timeout_seconds      = 60;
        $this->timeout_microseconds = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        if(is_resource($this->handle))
        {
            fclose($this->handle);
        }

        unset($this->context_options);
        unset($this->meta_data);
        unset($this->error_number);
        unset($this->error_message);
        unset($this->blocking);
        unset($this->notification);
        unset($this->flag);
        unset($this->timeout_seconds);
        unset($this->timeout_microseconds);
        unset($this->handle);
        unset($this->context);
    }

    /**
     * Get access to certain private attributes.
     *
     * This gives access to meta_data.
     *
     * @param String $name Attribute name
     *
     * @return mixed $return Value of the chosen attribute
     */
    public function __get($name)
    {
        switch ($name)
        {
            case 'meta_data':
                return $this->{$name};
            default:
                return NULL;
        }
    }

    /**
     * Set an option for the stream stream context in the given wrapper.
     *
     * @param String $wrapper The wrapper of the option.
     * @param String $option  The option name
     * @param mixed  $value   The value of the option
     *
     * @return StreamSocket $self Self-reference
     */
    public function set_context_option($wrapper, $option, $value)
    {
        if(! is_string($wrapper))
        {
            return $this;
        }

        if(! in_array($wrapper, stream_get_wrappers() ) &&
           ! in_array($wrapper, stream_get_transports()))
        {
            return $this;
        }

        if(! array_key_exists($wrapper, $this->context_options))
        {
            $this->context_options[$wrapper] = array();
        }

        $this->context_options[$wrapper][$option] = $value;

        return $this;
    }

    /**
     * Set the options for the stream stream context.
     *
     * @param array $options The options array
     *
     * @return StreamSocket $self Self-reference
     */
    public function set_context_options($options)
    {
        if(! is_array($options))
        {
            return $this;
        }

        foreach($options as $wrapper => $pair)
        {
            foreach($pair as $option => $value)
            {
                $this->set_context_option($wrapper, $option, $value);
            }
        }

        return $this;
    }

    /**
     * Set the blocking mode for the stream.
     *
     * @param Boolean $blocking Wether the stream is set to blocking mode or not
     *
     * @return StreamSocket $self Self-reference
     */
    public function set_blocking($blocking)
    {
        if(is_bool($blocking))
        {
            $this->blocking = $blocking;
        }

        return $this;
    }

    /**
     * Set the timeout for the stream for read/write purpose.
     *
     * @param Integer $seconds      The part in seconds of the timeout
     * @param Integer $microseconds The part in microseconds of the timeout
     *
     * @return StreamSocket $self Self-reference
     */
    public function set_timeout($seconds, $microseconds = 0)
    {
        if(is_int($seconds) && $seconds >= 0)
        {
            $this->timeout_seconds = $seconds;
        }

        if(is_int($microseconds) && $microseconds > 0)
        {
            $this->timeout_microseconds = $microseconds;
        }

        return $this;
    }

    /**
     * Set the notification callback function of this stream stream context, see link for details.
     *
     * @param Callable $notification The notification function name
     *
     * @return StreamSocket $self Self-reference
     * @link http://www.php.net/manual/en/function.stream-notification-callback.php
     */
    public function set_notification_callback($notification)
    {
        if(is_callable($notification))
        {
            $this->notification = $notification;
        }

        return $this;
    }

    /**
     * Tells wether the stream has data to read or not.
     *
     * @return Boolean $return TRUE if the socket has data to read, FALSE otherwise and
     *                         NULL if the stream is closed or if an error occured
     */
    public function is_ready_to_read()
    {
        return $this->changed(TRUE, FALSE, FALSE);
    }

    /**
     * Tells wether the stream is available for writing.
     *
     * @return Boolean $return TRUE if the socket is ready for writing, FALSE otherwise and
     *                         NULL if the stream is closed or if an error occured
     */
    public function is_ready_to_write()
    {
        return $this->changed(FALSE, TRUE, FALSE);
    }

    /**
     * Tells wether the stream is ready to read high priority exceptional ("out-of-band") data.
     *
     * @return mixed Boolean TRUE if the socket has thrown an exception, FALSE otherwise and
     *                       NULL if the stream is closed or if an error occured
     */
    public function  is_ready_to_read_exceptional_data()
    {
        return $this->changed(FALSE, FALSE, TRUE);
    }

    /**
     * Returns the changed state of this stream, if it is readable, writable, has exceptional data to read.
     *
     * @param boolean $read      Set to TRUE for testing read availability of the stream purpose
     * @param boolean $write     Set to TRUE for testing write availability of the stream purpose
     * @param boolean $exception Set to TRUE for testing exception thrown by the stream purpose
     *
     * @return Boolean $return TRUE state has change or launched an exception, FALSE otherwise and
     *                         NULL if the stream is closed or if an error occured
     */
    protected function changed($read, $write, $exception)
    {
        if(!is_resource($this->handle))
        {
            return NULL;
        }

        $read_array   = $read      ? array($this->handle) : NULL;
        $write_array  = $write     ? array($this->handle) : NULL;
        $except_array = $exception ? array($this->handle) : NULL;

        $changed = stream_select(
                $read_array,
                $write_array,
                $except_array,
                $this->timeout_seconds,
                $this->timeout_microseconds
                );

        if($changed === FALSE)
        {
            return NULL;
        }
        else
        {
            return ($changed > 0);
        }
    }

    /**
     * Create the context of this stream with the options passed, callback function if set.
     *
     * @return resource $return The created context resource
     */
    protected function create_context()
    {
        $this->context = stream_context_create($this->context_options);

        if(is_callable($this->notification))
        {
            stream_context_set_params($this->context, array('notification' => $this->notification));
        }

        return $this->context;
    }

    /**
     * Add the flag for stream resource creation.
     *
     * @param String $flag the flag identifier of the flag to add
     *
     * @return StreamSocket $self Self-reference
     */
    public abstract function add_flag($flag);

    /**
     * Create the resource handle of this stream socket.
     *
     * @return resource $return The created handle
     */
    protected abstract function create_handle();

    /**
     * Write the given data on the stream.
     *
     * @param mixed $data the data to write
     *
     * @return mixed $return the count of written bytes or FALSE if an error occurs
     */
    public abstract function write($data);

    /**
     * Read data from the stream.
     *
     * @param Integer $length The requested length of byte to read, all availdable data if -1(default value)
     *
     * @return String $return The n byte read from the stream, FALSE if an error occured
     */
    public abstract function read($length = -1);

    /**
     * Open the stream if not already opened.
     *
     * @return Boolean $return TRUE if the stream is open, FALSE otherwise
     */
    public abstract function connect();

    /**
     * Close the stream if not already closed, optional.
     *
     * @return Boolean $return TRUE if stream properly closed, FALSE om error
     */
    public abstract function disconnect();

}

?>
