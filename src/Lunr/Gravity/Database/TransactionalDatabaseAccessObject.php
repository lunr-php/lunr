<?php
/**
 * This file contains the DatabaseAccessObject for transactional access.
 *
 * @package Skysail\Gravity\Database
 * @author  Sean Molenaar <s.molenaar@m2mobi.com>
 */

namespace Lunr\Gravity\Database;

/**
 * TransactionalDatabaseAccess class
 */
abstract class TransactionalDatabaseAccessObject extends DatabaseAccessObject
{

    /**
     * Begin a transaction.
     *
     * @return void
     */
    public function begin_transaction()
    {
        $this->db->begin_transaction();
    }

    /**
     * Roll back the changes in a transaction.
     *
     * @return void
     */
    public function rollback_transaction()
    {
        $this->db->rollback();
    }

    /**
     * Commit the changes in a transaction.
     *
     * @return void
     */
    public function commit_transaction()
    {
        $this->db->commit();
    }

    /**
     * End a transaction.
     *
     * @return void
     */
    public function end_transaction()
    {
        $this->db->end_transaction();
    }

}
