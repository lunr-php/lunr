<?php

/**
 * This file contains the DAO for storing php session information
 * in the database
 *
 * PHP Version 5.4
 *
 * @category   DAO
 * @package    Sphere
 * @subpackage DAO
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere;

use Lunr\Gravity\Database\DatabaseAccessObject;

/**
 * Sphere Session DAO
 *
 * @category   DAO
 * @package    Sphere
 * @subpackage DAO
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class SessionDAO extends DatabaseAccessObject
{

    /**
     * Constructor.
     *
     * @param DatabaseConnection $connection Shared instance of a database connection class
     * @param LoggerInterface    $logger     Shared instance of a Logger class
     */
    public function __construct($connection, $logger)
    {
        parent::__construct($connection, $logger);
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
        $builder = $this->db->get_new_dml_query_builder_object();
        $builder->select($builder->result_column('sessionData'));
        $builder->from($builder->table('user_sessions'));
        $builder->where($builder->column('sessionID'), $builder->value($id));
        $builder->where($builder->column('expires'), $builder->intvalue(time()), '>');

        $query  = $this->db->query($builder->get_select_query());
        $result = $this->result_cell($query, 'sessionData');
        if($result != FALSE)
        {
            return base64_decode($result);
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
        $builder_select = $this->db->get_new_dml_query_builder_object();
        $this->db->begin_transaction();
        $builder_select->from($builder_select->table('user_sessions'));
        $builder_select->where($builder_select->column('sessionID'), $builder_select->value($id));
        $builder_select->lock_mode('FOR UPDATE');

        $query = $this->db->query($builder_select->get_select_query());
        if ($query->has_failed())
        {
            $this->db->rollback();
        }
        else
        {
            $builder_replace = $this->db->get_new_dml_query_builder_object();
            $builder_replace->into('user_sessions');
            $data = array(
                $builder_replace->column('sessionID')   => $builder_replace->value($id),
                $builder_replace->column('sessionData') => $builder_replace->value(base64_encode($session_data)),
                $builder_replace->column('expires')     => $builder_replace->value($time)
            );
            $builder_replace->set($data);

            $query = $this->db->query($builder_replace->get_replace_query());
            $this->db->commit();
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
        $builder_select = $this->db->get_new_dml_query_builder_object();
        $this->db->begin_transaction();
        $builder_select->from($builder_select->table('user_sessions'));
        $builder_select->where($builder_select->column('sessionID'), $builder_select->value($id));
        $builder_select->lock_mode('FOR UPDATE');

        $query = $this->db->query($builder_select->get_select_query());
        if ($query->has_failed())
        {
            $this->db->rollback();
        }
        else
        {
            if ($query->number_of_rows() > 0)
            {
                $builder_delete = $this->db->get_new_dml_query_builder_object();
                $builder_delete->from($builder_delete->table('user_sessions'));
                $builder_delete->where($builder_delete->column('sessionID'), $builder_delete->value($id));

                $query = $this->db->query($builder_delete->get_delete_query());
                $this->db->commit();
            }
            else
            {
                $this->db->rollback();
            }
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
        $builder = $this->db->get_new_dml_query_builder_object();
        $builder->from($builder->table('user_sessions'));
        $builder->where($builder->column('expires'), $builder->intvalue(time()), '<');

        $this->db->query($builder->get_delete_query());
    }

}

?>
