<?php
/**
 * This file contains the DatabaseAccessObject for transactional access.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
