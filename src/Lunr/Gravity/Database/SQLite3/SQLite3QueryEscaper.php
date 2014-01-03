<?php

/**
 * SQLite3 query escaper class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3;

use Lunr\Gravity\Database\DatabaseQueryEscaper;

/**
 * This class provides SQLite3 specific escaping methods for SQL query parts.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class SQLite3QueryEscaper extends DatabaseQueryEscaper
{

    /**
     * The left identifier delimiter.
     * @var String
     */
    const IDENTIFIER_DELIMITER_L = '"';

    /**
     * The right identifier delimiter.
     * @var String
     */
    const IDENTIFIER_DELIMITER_R = '"';

    /**
     * Constructor.
     *
     * @param SQLite3Connection $db Instance of the SQLite3Connection class.
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
     * @param String $charset   Unused with SQLite
     *
     * @return String $return Defined and escaped value
     */
    public function value($value, $collation = '', $charset = '')
    {
        return trim($this->collate('\'' . $this->db->escape_string($value) . '\'', $collation));
    }

    /**
     * Not supported by sqlite. Returns the same as value.
     *
     * @param mixed  $value     Input
     * @param String $collation Collation name
     * @param String $charset   Unused with SQLite
     *
     * @return String $return Defined, escaped and unhexed value
     */
    public function hexvalue($value, $collation = '', $charset = '')
    {
        return $this->value($value, $collation, $charset);
    }

    /**
     * Define and escape input as a hexadecimal value.
     *
     * @param mixed  $value     Input
     * @param String $match     Whether to match forward, backward or both
     * @param String $collation Collation name
     * @param String $charset   Unused with SQLite
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

        return trim($this->collate($string, $collation));
    }

    /**
     * Define and escape input as index hint.
     *
     * @param String $keyword Whether to use INDEXED BY or NOT INDEXED the index/indices
     * @param array  $indices Array of indices
     * @param String $for     Unused with SQLite
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

        $valid_keywords = array('INDEXED BY', 'NOT INDEXED');

        if (!in_array($keyword, $valid_keywords))
        {
            $keyword = 'INDEXED BY';
        }

        $indices = array_map(array($this, 'escape_location_reference'), $indices);
        $indices = implode(', ', $indices);

        return $keyword . ' ' . $indices;
    }

}

?>
