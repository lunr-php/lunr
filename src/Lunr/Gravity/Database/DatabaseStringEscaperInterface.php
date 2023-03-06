<?php

/**
 * Database escaper interface.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2023, Move Agency B.V., Zwolle, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database;

/**
 * This interface defines the query escape primitives.
 */
interface DatabaseStringEscaperInterface
{

    /**
     * Return a new instance of a QueryEscaper object.
     *
     * @return DatabaseQueryEscaper $escaper New DatabaseQueryEscaper object instance
     */
    public function get_query_escaper_object();

    /**
     * Escape a string to be used in a SQL query.
     *
     * @param string $string The string to escape
     *
     * @return mixed $return The escaped string on success, FALSE on error
     */
    public function escape_string($string);

}

?>
