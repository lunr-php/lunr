<?php

/**
 * SQLite3 query escaper class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3;

use Lunr\Gravity\Database\DatabaseQueryEscaper;

/**
 * This class provides SQLite3 specific escaping methods for SQL query parts.
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
     * @param string $collation Collation name
     * @param string $charset   Unused with SQLite
     *
     * @return string $return Defined and escaped value
     */
    public function value($value, $collation = '', $charset = '')
    {
        return trim($this->collate('\'' . $this->db->escape_string($value) . '\'', $collation));
    }

    /**
     * Not supported by sqlite. Returns the same as value.
     *
     * @param mixed  $value     Input
     * @param string $collation Collation name
     * @param string $charset   Unused with SQLite
     *
     * @return string $return Defined, escaped and unhexed value
     */
    public function hexvalue($value, $collation = '', $charset = '')
    {
        return $this->value($value, $collation, $charset);
    }

    /**
     * Define and escape input as a hexadecimal value.
     *
     * @param mixed  $value     Input
     * @param string $match     Whether to match forward, backward or both
     * @param string $collation Collation name
     * @param string $charset   Unused with SQLite
     *
     * @return string $return Defined, escaped and unhexed value
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
     * @param string $keyword Whether to use INDEXED BY or NOT INDEXED the index/indices
     * @param array  $indices Array of indices
     * @param string $for     Unused with SQLite
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

        $valid_keywords = [ 'INDEXED BY', 'NOT INDEXED' ];

        if (!in_array($keyword, $valid_keywords))
        {
            $keyword = 'INDEXED BY';
        }

        $indices = array_map([ $this, 'escape_location_reference' ], $indices);
        $indices = implode(', ', $indices);

        return $keyword . ' ' . $indices;
    }

}

?>
