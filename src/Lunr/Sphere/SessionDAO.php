<?php

/**
 * This file contains the DAO for storing php session information
 * in the database
 *
 * @package    Lunr\Sphere
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere;

use Lunr\Gravity\Database\DatabaseAccessObject;

/**
 * Sphere Session DAO
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
     * @param string $id Session ID
     *
     * @return string The Session Data
     */
    public function read_session_data($id)
    {
        $builder = $this->db->get_new_dml_query_builder_object(FALSE);

        $builder->select($this->escaper->result_column('sessionData'))
                ->from($this->escaper->table('user_sessions'))
                ->where($this->escaper->column('sessionID'), $this->escaper->value($id))
                ->where($this->escaper->column('expires'), $this->escaper->intvalue(time()), '>');

        $query  = $this->db->query($builder->get_select_query());
        $result = $this->result_cell($query, 'sessionData');

        return base64_decode($result);
    }

    /**
     * Save session data into the database.
     *
     * @param string $id           Session ID
     * @param string $session_data Session data
     * @param int    $time         Expiration timestamp
     *
     * @return void
     */
    public function write_session_data($id, $session_data, $time)
    {
        $this->db->begin_transaction();

        $builder_select = $this->db->get_new_dml_query_builder_object(FALSE);

        $builder_select->from($this->escaper->table('user_sessions'))
                       ->where($this->escaper->column('sessionID'), $this->escaper->value($id))
                       ->lock_mode('FOR UPDATE');

        $query = $this->db->query($builder_select->get_select_query());

        if ($query->has_failed())
        {
            $this->db->rollback();
        }
        else
        {
            $data = [
                $this->escaper->column('sessionID')   => $this->escaper->value($id),
                $this->escaper->column('sessionData') => $this->escaper->value(base64_encode($session_data)),
                $this->escaper->column('expires')     => $this->escaper->intvalue($time),
            ];

            $builder_replace = $this->db->get_new_dml_query_builder_object(FALSE);
            $builder_replace->into($this->escaper->table('user_sessions'))
                            ->set($data);

            $query = $this->db->query($builder_replace->get_replace_query());

            $this->db->commit();
        }

        $this->db->end_transaction();
    }

    /**
     * Remove a no-longer active session.
     *
     * @param string $id Session ID
     *
     * @return void
     */
    public function delete_session($id)
    {
        $this->db->begin_transaction();

        $builder_select = $this->db->get_new_dml_query_builder_object(FALSE);

        $builder_select->from($this->escaper->table('user_sessions'))
                       ->where($this->escaper->column('sessionID'), $this->escaper->value($id))
                       ->lock_mode('FOR UPDATE');

        $query = $this->db->query($builder_select->get_select_query());

        if ($query->number_of_rows() > 0)
        {
            $builder_delete = $this->db->get_new_dml_query_builder_object(FALSE);

            $builder_delete->from($this->escaper->table('user_sessions'))
                           ->where($this->escaper->column('sessionID'), $this->escaper->value($id));

            $query = $this->db->query($builder_delete->get_delete_query());
            $this->db->commit();
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
        $builder = $this->db->get_new_dml_query_builder_object(FALSE);

        $builder->from($this->escaper->table('user_sessions'))
                ->where($this->escaper->column('expires'), $this->escaper->intvalue(time()), '<');

        $this->db->query($builder->get_delete_query());
    }

}

?>
