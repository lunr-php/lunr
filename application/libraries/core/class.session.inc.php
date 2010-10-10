<?php

/**
 * Session Wrapper Class
 * @author M2Mobi, Heinz Wiesinger
 */
class Session
{

    /**
     * Reference to low-level session manager
     * @var SessionManager
     */
    private $manager;

    /**
     * Constructor
     * @param Boolean $database Whether to use the database based
     *   SessionManager class or not
     */
    public function __construct($database = TRUE)
    {
        if ($database)
        {
            require_once("class.sessionmanager.inc.php");
            $this->manager = new SessionManager();
        }

        // kill autostarted sessions
        session_write_close();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset($this->manager);
    }

    /**
     * Store a key->value pair in the current session
     * @param mixed $key Identifier
     * @param mixed $value Value
     * @return void
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Remove a key->value pair from the current session
     * @param mixed $key Identifier
     * @return void
     */
    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Get a key->value pair from the current session
     * @param mixed $key Identifier
     * @return void
     */
    public function get($key)
    {
        if (isset($_SESSION[$key]))
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
     * @return String $session_id
     */
    public function get_session_id()
    {
        return session_id();
    }

    /**
     * Start a new session or continure an existing one
     * @param String $id Predefined Session ID
     * @return void
     */
    public function start($id = "")
    {
        if ($id != "")
        {
            session_id($id);
        }
        session_start();
    }

    /**
     * End the currently active session
     * @return void
     */
    public function destroy()
    {
        $_SESSION = array();
        session_destroy();
    }

}

?>
