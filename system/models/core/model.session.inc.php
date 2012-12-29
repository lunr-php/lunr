<?php

/**
 * This file contains the model for storing php session information
 * in the database
 *
 * PHP Version 5.3
 *
 * @category   Models
 * @package    Core
 * @subpackage Models
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Models\Core;

use Lunr\Libraries\Core\Model;

/**
 * Core Session Model
 *
 * @category   Models
 * @package    Core
 * @subpackage Models
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class SessionModel extends Model
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        global $db;
        parent::__construct($db);
        $this->get_write_access();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Read session data from the database.
     *
     * @param String $id Session ID
     *
     * @return mixed The Session Data on success, False on failure
     */
    public function read_session_data($id)
    {
        $this->db->select('sessionData');
        $this->db->where('sessionID', $id);
        $this->db->where('expires', time(), '>');
        $query = $this->db->get('user_sessions');
        if ($query)
        {
            if ($query->num_rows() > 0)
            {
                return base64_decode($query->field('sessionData'));
            }
            else
            {
                return '';
            }
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Save session data into the database.
     *
     * @param String  $id           Session ID
     * @param String  $session_data Session data
     * @param Integer $time         expiration timestamp
     *
     * @return void
     */
    public function write_session_data($id, $session_data, $time)
    {
        $this->db->begin_transaction();
        $this->db->select_for_update('*', FALSE);
        $this->db->where('sessionID', $id);
        $query = $this->db->get('user_sessions');
        if ($query)
        {
            $data = array(
                'sessionID'   => $id,
                'sessionData' => base64_encode($session_data),
                'expires'     => $time
            );
            $this->db->replace('user_sessions', $data);
            $this->db->commit();
        }
        else
        {
            $this->db->rollback();
        }

        $this->db->end_transaction();
    }

    /**
     * Remove a no-longer active session.
     *
     * @param String $id Session ID
     *
     * @return void
     */
    public function delete_session($id)
    {
        $this->db->begin_transaction();
        $this->db->select_for_update('*', FALSE);
        $this->db->where('sessionID', $id);
        $query = $this->db->get('user_sessions');
        if ($query)
        {
            if ($query->num_rows() > 0)
            {
                $this->db->where('sessionID', $id);
                $this->db->delete('user_sessions');
                $this->db->commit();
            }
            else
            {
                $this->db->rollback();
            }
        }
        else
        {
            $this->db->rollback();
        }

        $this->db->end_transaction();
    }

    /**
     * Remove expired sessions.
     *
     * @return void
     */
    public function session_gc()
    {
        $this->db->where('expires', time(), '<');
        $this->db->delete('user_sessions');
    }

}

?>
