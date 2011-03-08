<?php

/**
 * This file contains a PHP session handling wrapper class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * Session Wrapper Class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Session
{

    /**
     * Reference to low-level session manager
     * @var SessionManager
     */
    private $manager;

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
     * Constructor
     *
     * @param Boolean $database Whether to use the database based
     *                          SessionManager class or not
     */
    public function __construct($database = TRUE)
    {
        if ($database)
        {
            require_once("class.sessionmanager.inc.php");
            $this->manager = new SessionManager();
        }

        $this->closed = FALSE;
        $this->started = FALSE;

        // kill autostarted sessions
        session_write_close();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        if (!$this->closed)
        {
            $this->close();
        }
        unset($this->manager);
        unset($this->closed);
        unset($this->started);
    }

    /**
     * Store a key->value pair in the current session
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
     * Remove a key->value pair from the current session
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
     * Get a key->value pair from the current session
     *
     * @param mixed $key Identifier
     *
     * @return void
     */
    public function get($key)
    {
        if ($this->started && isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Get the current session ID
     *
     * @return String $session_id
     */
    public function get_session_id()
    {
        return session_id();
    }

    /**
     * Replace the current sessionid with a new one
     *
     * @return String $session_id
     */
    public function get_new_session_id()
    {
        session_regenerate_id();
        return $this->get_session_id();
    }

    /**
     * Start a new session or continure an existing one
     *
     * @param String $id Predefined Session ID
     *
     * @return void
     */
    public function start($id = "")
    {
        if (!$this->started)
        {
            if ($id != "")
            {
                session_id($id);
            }
            session_start();
            $this->started = TRUE;
            $this->closed = FALSE;
        }
    }

    /**
     * Close the session and write data
     *
     * @return void
     */
    public function close()
    {
        session_write_close();
        $this->closed = TRUE;
        $this->started = FALSE;
    }

    /**
     * End the currently active session
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
