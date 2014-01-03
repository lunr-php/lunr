<?php

/**
 * MySQL query escaper class.
 *
 * PHP Version 5.4
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

use Lunr\Gravity\Database\DatabaseQueryEscaper;

/**
 * This class provides MySQL specific escaping methods for SQL query parts.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MySQLQueryEscaper extends DatabaseQueryEscaper
{

    /**
     * Constructor.
     *
     * @param MySQLConnection $db Instance of the MySQLConnection class.
     */
    public function __construct($db)
    {
        parent::__construct($db);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Define and escape input as value.
     *
     * @param mixed  $value     Input
     * @param String $collation Collation name
     * @param String $charset   Charset name
     *
     * @return String $return Defined and escaped value
     */
    public function value($value, $collation = '', $charset = '')
    {
        return trim($charset . ' ' . $this->collate('\'' . $this->db->escape_string($value) . '\'', $collation));
    }

    /**
     * Define and escape input as a hexadecimal value.
     *
     * @param mixed  $value     Input
     * @param String $collation Collation name
     * @param String $charset   Charset name
     *
     * @return String $return Defined, escaped and unhexed value
     */
    public function hexvalue($value, $collation = '', $charset = '')
    {
        return trim($charset . ' ' . $this->collate('UNHEX(\'' . $this->db->escape_string($value) . '\')', $collation));
    }

    /**
     * Define and escape input as a hexadecimal value.
     *
     * @param mixed  $value     Input
     * @param String $match     Whether to match forward, backward or both
     * @param String $collation Collation name
     * @param String $charset   Charset name
     *
     * @return String $return Defined, escaped and unhexed value
     */
    public function likevalue($value, $match = 'both', $collation = '', $charset = '')
    {
        switch ($match)
        {
            case 'forward':
                $string = '\'' . $this->db->escape_string($value) . '%\'';
                break;
            case 'backward':
                $string = '\'%' . $this->db->escape_string($value) . '\'';
                break;
            case 'both':
            default:
                $string = '\'%' . $this->db->escape_string($value) . '%\'';
                break;
        }

        return trim($charset . ' ' . $this->collate($string, $collation));
    }

    /**
     * Define and escape input as index hint.
     *
     * @param String $keyword Whether to USE, FORCE or IGNORE the index/indices
     * @param array  $indices Array of indices
     * @param String $for     Whether to use the index hint for JOIN, ORDER BY or GROUP BY
     *
     * @return mixed $return NULL for invalid indices, escaped string otherwise.
     */
    public function index_hint($keyword, $indices, $for = '')
    {
        if (!is_array($indices) || empty($indices))
        {
            return NULL;
        }

        $keyword = strtoupper($keyword);

        $valid_keywords = array('USE', 'IGNORE', 'FORCE');
        $valid_for      = array('JOIN', 'ORDER BY', 'GROUP BY', '');

        if (!in_array($keyword, $valid_keywords))
        {
            $keyword = 'USE';
        }

        if (!in_array($for, $valid_for))
        {
            $for = '';
        }

        $indices = array_map(array($this, 'escape_location_reference'), $indices);
        $indices = implode(', ', $indices);

        if ($for === '')
        {
            return $keyword . ' INDEX (' . $indices . ')';
        }
        else
        {
            return $keyword . ' INDEX FOR ' . $for . ' (' . $indices . ')';
        }
    }

}

?>
