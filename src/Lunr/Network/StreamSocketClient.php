<?php

/**
 * This file contains the stream socket client wrapper class.
 *
 * PHP Version 5.3
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
 * Stream socket client wrapper class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class StreamSocketClient extends StreamSocket
{

    /**
     * The remote socket uri
     * @var String
     */
    protected $uri;

    /**
     * The connection time out for this stream socket client
     * @var Float
     */
    protected $init_timeout;

    /**
     * The connected status flag of this stream.
     * @var Boolean
     */
    protected $connected;

    /**
     * Constructor.
     *
     * @param String $uri          The target uri of this client stream
     * @param Float  $init_timeout The timeout value for stream socket creation,
     *                             escaped to float if integer supplied, ignored
     *                             otherwise
     */
    public function __construct($uri, $init_timeout = NULL)
    {
        parent::__construct();

        $this->uri = $uri;

        $this->init_timeout = floatval(ini_get('default_socket_timeout'));

        if($init_timeout !== NULL)
        {
            if(is_int($init_timeout))
            {
                $init_timeout = floatval($init_timeout);
            }

            if(is_float($init_timeout))
            {
                $this->init_timeout = $init_timeout;
            }
        }

        $this->connected = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->disconnect();

        unset($this->uri);
        unset($this->init_timeout);

        parent::__destruct();
    }

     /**
     * Add the flag for stream resource creation.
     *
     * @param String $flag the flag indentifier of the flag to add
     *
     * @return StreamSocketClient $self Self-reference
     */
    public function add_flag($flag)
    {
        if((substr($flag, 0, 13) === 'STREAM_CLIENT') && (defined($flag) === TRUE))
        {
            $this->flags[$flag] = constant($flag);
        }

        return $this;
    }

    /**
     * Create the resource handle of this stream socket, updates the meta data if stream connecteded.
     *
     * @return mixed $return The created handle, FALSE on failure
     */
    protected function create_handle()
    {
        $this->create_context();

        if(empty($this->flags))
        {
            $flags = STREAM_CLIENT_CONNECT;
        }
        else
        {
            $flags = array_reduce($this->flags, array($this, 'create_flags'));
        }

        $this->handle = stream_socket_client(
                $this->uri,
                $this->errno,
                $this->errmsg,
                $this->init_timeout,
                $flags,
                $this->context
        );

        if(!is_resource($this->handle))
        {
            $this->handle = NULL;
            return FALSE;
        }

        stream_set_blocking($this->handle, $this->blocking ? 1: 0);
        stream_set_timeout($this->handle, $this->timeout_seconds, $this->timeout_microseconds);
        //update the metadata
        $this->meta_data = stream_get_meta_data($this->handle);

        $this->connected = TRUE;

        return $this->handle;
    }

    /**
     * Creates the flag to be used for the handle creation.
     *
     * @param Integer $flags The holding value of the flags to be created
     * @param Integer $flag  The value to add to the current flags
     *
     * @return Integer $flags The binary OR images of the flags used for the handle creation
     */
    private function create_flags($flags, $flag)
    {
        $flags = $flags | $flag;

        return $flags;
    }

    /**
     * Write the given data on the stream, updates the meta data if stream connecteded.
     *
     * @param mixed $data the data to write
     *
     * @return mixed $return the count of written bytes or FALSE if an error occurs
     */
    public function write($data)
    {
        if(!$this->connect())
        {
            return FALSE;
        }

        $return = fwrite($this->handle, $data);
        //update the metadata
        $this->meta_data = stream_get_meta_data($this->handle);

        return $return;
    }

    /**
     * Read data from the stream.
     *
     * @param Integer $length The requested length of byte to read, all availdable data if -1(default value)
     *
     * @return String $return The n byte read from the stream, FALSE if an error occured
     */
    public function read($length = -1)
    {
        if(!$this->connect())
        {
            return FALSE;
        }

        return stream_get_contents($this->handle, $length);
    }

    /**
     * Open the stream if not already connecteded, handle created as consequence.
     *
     * Calling connected is optional as read, read_all and write call it as well.
     *
     * @return Boolean $return TRUE if the stream is connecteded, FALSE otherwise
     */
    public function connect()
    {
        if($this->connected)
        {
            return TRUE;
        }

        return is_resource($this->create_handle());
    }

    /**
     * Close the resource associated to the stream, updates the metadata if stream not already closed.
     *
     * @return Boolean $return TRUE if successfully closed the resource, FALSE otherwise
     */
    public function disconnect()
    {
        if(! $this->connected)
        {
            return TRUE;
        }

        //update the metadata
        $this->meta_data = stream_get_meta_data($this->handle);

        $return = fclose($this->handle);

        $this->handle = NULL;

        $this->connected = FALSE;

        return $return;
    }

}

?>
