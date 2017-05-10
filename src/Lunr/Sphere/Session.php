<?php

/**
 * This file contains a PHP session handling wrapper class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Sphere
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Sean Molenaar   <sean@m2mobi.com>
 * @copyright  2010-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere;

/**
 * Session Wrapper Class
 */
class Session
{

    /**
     * Check whether session is already closed
     * @var Boolean
     */
    private $closed;

    /**
     * Check whether session is already started
     * @var Boolean
     */
    private $started;

    /**
     * Constructor.
     * @param \SessionHandlerInterface|null $session_handler Handler for the session
     */
    public function __construct($session_handler = NULL)
    {
        if ($session_handler !== NULL)
        {
            $this->setSessionHandler($session_handler);
        }

        $this->closed  = FALSE;
        $this->started = FALSE;

        // kill autostarted sessions
        session_write_close();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        if (!$this->closed)
        {
            $this->close();
        }

        unset($this->closed);
        unset($this->started);
    }

    /**
     * Set SessionHandler.
     *
     * @param \SessionHandlerInterface $session_handler Session handler
     *
     * @return boolean
     */
    public function setSessionHandler($session_handler)
    {
        return session_set_save_handler($session_handler, TRUE);
    }

    /**
     * Store a key->value pair in the current session.
     *
     * @param mixed $key   Identifier
     * @param mixed $value Value
     *
     * @return void
     */
    public function set($key, $value)
    {
        if (!$this->closed && $this->started)
        {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * Remove a key->value pair from the current session.
     *
     * @param mixed $key Identifier
     *
     * @return void
     */
    public function delete($key)
    {
        if (!$this->closed && $this->started)
        {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Get a key->value pair from the current session.
     *
     * @param mixed $key Identifier
     * @param mixed $alt What to return if not found
     *
     * @return mixed
     */
    public function get($key, $alt = NULL)
    {
        if ($this->started && isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        else
        {
            return $alt;
        }
    }

    /**
     * Get the current session ID.
     *
     * @return String $session_id
     */
    public function sessionId()
    {
        return session_id();
    }

    /**
     * Get the current session ID.
     *
     * @param string $id Predefined Session ID
     *
     * @return void
     */
    public function setSessionId($id)
    {
        if ($id == '')
        {
            return;
        }

        session_id($id);
    }

    /**
     * Replace the current sessionid with a new one.
     *
     * @return String $session_id
     */
    public function regenerateId()
    {
        session_regenerate_id();
        return $this->sessionId();
    }

    /**
     * Start a new session or continue an existing one.
     *
     * @param String $id Predefined Session ID
     *
     * @return bool
     */
    public function start($id = '')
    {
        if ($this->started)
        {
            return TRUE;
        }

        $this->setSessionId($id);

        $success       = session_start();
        $this->started = $success;
        $this->closed  = !$success;

        return $success;
    }

    /**
     * Resumes a previously-existing session.
     *
     * @param String $id Predefined Session ID
     *
     * @return bool
     */
    public function resume($id = '')
    {
        return $this->start($id);
    }

    /**
     * Close the session and write data.
     *
     * @return void
     */
    public function close()
    {
        session_write_close();
        $this->closed  = TRUE;
        $this->started = FALSE;
    }

    /**
     * End the currently active session.
     *
     * @return void
     */
    public function destroy()
    {
        if ($this->started)
        {
            $_SESSION = [];
            session_destroy();
        }
    }

}

?>
