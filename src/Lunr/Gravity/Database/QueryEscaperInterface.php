<?php

/**
 * Query escaper interface.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database;

/**
 * This interface defines the query escape primitives.
 */
interface QueryEscaperInterface
{

    /**
     * Define and escape input as column.
     *
     * @param string $name      Input
     * @param string $collation Collation name
     *
     * @return string $return Defined and escaped column name
     */
    public function column($name, $collation = '');

    /**
     * Define and escape input as a result column.
     *
     * @param string $column Result column name
     * @param string $alias  Alias
     *
     * @return string $return Defined and escaped result column
     */
    public function result_column($column, $alias = '');

    /**
     * Define and escape input as a result column and transform values to hexadecimal.
     *
     * @param string $column Result column name
     * @param string $alias  Alias
     *
     * @return string $return Defined and escaped result column
     */
    public function hex_result_column($column, $alias = '');

    /**
     * Define and escape input as table.
     *
     * @param string $table Table name
     * @param string $alias Alias
     *
     * @return string $return Defined and escaped table
     */
    public function table($table, $alias = '');

    /**
     * Define and escape input as value.
     *
     * @param mixed  $value     Input
     * @param string $collation Collation name
     * @param string $charset   Charset name
     *
     * @return string $return Defined and escaped value
     */
    public function value($value, $collation = '', $charset = '');

    /**
     * Define and escape input as a hexadecimal value.
     *
     * @param mixed  $value     Input
     * @param string $collation Collation name
     * @param string $charset   Charset name
     *
     * @return string $return Defined, escaped and unhexed value
     */
    public function hexvalue($value, $collation = '', $charset = '');

    /**
     * Define and escape input as a value in a LIKE expression.
     *
     * @param mixed  $value     Input
     * @param string $match     Whether to match forward, backward or both. Defaults to both
     * @param string $collation Collation name
     * @param string $charset   Charset name
     *
     * @return string $return Defined, escaped and wildcarded value
     */
    public function likevalue($value, $match = 'both', $collation = '', $charset = '');

    /**
     * Define and escape input as integer value.
     *
     * @param mixed $value Input to escape as integer
     *
     * @return int Defined and escaped Integer value
     */
    public function intvalue($value);

    /**
    * Define input as a query within parentheses.
    *
    * @param string $value Input
    *
    * @return string $return Defined within parentheses
    */
    public function query_value($value);

    /**
    * Define input as a csv from an array within parentheses.
    *
    * @param array $value Input
    *
    * @return string $return Defined, escaped and within parentheses
    */
    public function list_value($value);

}

?>
