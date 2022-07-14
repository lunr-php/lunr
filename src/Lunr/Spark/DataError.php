<?php

/**
 * This file contains data error types.
 *
 * @package    Lunr\Spark
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

/**
 * Spark module data error types.
 */
class DataError
{

    /**
     * Unknown data field.
     * @var String
     */
    public const UNKNOWN_FIELD = 'E0';

    /**
     * Field data is not available.
     * @var String
     */
    public const NOT_AVAILABLE = 'E1';

    /**
     * Field data was not requested.
     * @var String
     */
    public const NOT_REQUESTED = 'E2';

    /**
     * Access to field data denied.
     * @var String
     */
    public const ACCESS_DENIED = 'E3';

}
