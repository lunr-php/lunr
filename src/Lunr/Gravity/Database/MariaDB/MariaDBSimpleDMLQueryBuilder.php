<?php

/**
 * MySQL/MariaDB database query builder class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MariaDB;

use Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder;
use Lunr\Gravity\Database\MySQL\MySQLQueryEscaper;

/**
 * This is a SQL query builder class for generating queries
 * only suitable for MariaDB, performing automatic escaping
 * of input values where appropriate.
 */
class MariaDBSimpleDMLQueryBuilder extends MySQLSimpleDMLQueryBuilder
{

    /**
     * Constructor.
     *
     * @param MariaDBDMLQueryBuilder $builder Instance of the MySQLDMLQueryBuilder class
     * @param MySQLQueryEscaper      $escaper Instance of the MySQLQueryEscaper class
     */
    public function __construct($builder, $escaper)
    {
        parent::__construct($builder, $escaper);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Define which columns to return from a non SELECT query.
     *
     * @param string $returning Columns to return
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function returning($returning)
    {
        $columns = '';
        foreach (explode(',', $returning) as $column)
        {
            if ($columns !== '')
            {
                $columns .= ', ';
            }

            $columns .= $this->escape_alias($column, FALSE);
        }

        $this->builder->returning($columns);
        return $this;
    }

    /**
     * Define a INTERSECT, INTERSECT DISTINCT or INTERSECT ALL clause of the SQL statement.
     *
     * @param string $sql_query SQL query reference
     * @param string $type      Type of INTERSECT operation to perform.
     *
     * @return MariaDBSimpleDMLQueryBuilder $self Self reference
     */
    public function intersect(string $sql_query, string $type = '')
    {
        $this->builder->intersect($this->escaper->query_value($sql_query), $type);
        return $this;
    }

    /**
     * Define a EXCEPT, EXCEPT DISTINCT or EXCEPT ALL clause of the SQL statement.
     *
     * @param string $sql_query SQL query reference
     * @param string $type      Type of EXCEPT operation to perform.
     *
     * @return MariaDBSimpleDMLQueryBuilder $self Self reference
     */
    public function except($sql_query, $type = NULL)
    {
        $this->builder->except($this->escaper->query_value($sql_query), $type);
        return $this;
    }

}

?>
