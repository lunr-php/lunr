<?php

/**
 * This file contains the implementation of an alternative
 * session handler for PHP, using the database instead of
 * the local filesystem for session storage.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

use Lunr\Models\Core\SessionModel;

/**
 * Background Session Management
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class SessionManager
{

    /**
     * Lifetime of a session instance
     * @var Integer
     */
    private $lifetime;

    /**
     * Instance of SessionModel
     * @var SessionModel
     */
    private $smodel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->lifetime = ini_get('session.gc_maxlifetime');

        session_set_save_handler(
            array(&$this, 'open'),
            array(&$this, 'close'),
            array(&$this, 'read'),
            array(&$this, 'write'),
            array(&$this, 'destroy'),
            array(&$this, 'gc')
        );

        $this->smodel = new SessionModel();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->smodel);
        unset($this->lifetime);
    }

    /**
     * Prepare for session usage.
     *
     * Since we use a database to store the data, we
     * don't really need to do anything here.
     *
     * @param String $path Path to store the session file
     * @param String $name Session name
     *
     * @return Boolean $return Returns always true
     */
    public function open($path, $name)
    {
        global $session_save_path;
        $session_save_path = $path;
        return TRUE;
    }

    /**
     * Close access to session file.
     *
     * Sine we do not use file for session dara storage
     * we don't need to do anything here.
     *
     * @return Boolean $return Returns always true
     */
    public function close()
    {
        return TRUE;
    }

    /**
     * Read session data from the database.
     *
     * @param String $id Session ID
     *
     * @return mixed $return Session data on success, False on failure
     */
    public function read($id)
    {
        return $this->smodel->read_session_data($id);
    }

    /**
     * Save session data into the database.
     *
     * @param String $id   Session ID
     * @param String $data Session Data
     *
     * @return Boolean $return Returns always true
     */
    public function write($id, $data)
    {
        $this->smodel->write_session_data($id, $data, time() + $this->lifetime);
        return TRUE;
    }

    /**
     * End currently active session.
     *
     * @param String $id Session ID
     *
     * @return Boolean $return Returns always true
     */
    public function destroy($id)
    {
        $this->smodel->delete_session($id);
        return TRUE;
    }

    /**
     * Clean up expired sessions.
     *
     * @return Boolean $return Returns always true
     */
    public function gc()
    {
        $this->smodel->session_gc();
        return TRUE;
    }

}

?>
