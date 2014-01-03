<?php

/**
 * This file contains a PHP session handling wrapper class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Libraries
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere;

/**
 * Session Wrapper Class
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Libraries
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
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
     */
    public function __construct()
    {
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
     * @param SessionHandlerInterface $session_handler Session handler
     *
     * @return boolean
     */
    public function set_session_handler($session_handler)
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
     *
     * @return mixed
     */
    public function get($key)
    {
        if ($this->started && isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Get the current session ID.
     *
     * @return String $session_id
     */
    public function get_session_id()
    {
        return session_id();
    }

    /**
     * Replace the current sessionid with a new one.
     *
     * @return String $session_id
     */
    public function get_new_session_id()
    {
        session_regenerate_id();
        return $this->get_session_id();
    }

    /**
     * Start a new session or continure an existing one.
     *
     * @param String $id Predefined Session ID
     *
     * @return void
     */
    public function start($id = '')
    {
        if ($this->started)
        {
            return;
        }

        if ($id != '')
        {
            session_id($id);
        }

        session_start();
        $this->started = TRUE;
        $this->closed  = FALSE;
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
            $_SESSION = array();
            session_destroy();
        }
    }

}

?>
