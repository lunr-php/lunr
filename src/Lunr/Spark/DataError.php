<?php

/**
 * This file contains data error types.
 *
 * PHP Version 5.4
 *
 * @category   Priority
 * @package    Spark
 * @subpackage Data
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

/**
 * Spark module data error types.
 *
 * @category   Priority
 * @package    Spark
 * @subpackage Data
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class DataError
{

    /**
     * Unknown data field.
     * @var String
     */
    const UNKNOWN_FIELD = 'E0';

    /**
     * Field data is not available.
     * @var String
     */
    const NOT_AVAILABLE = 'E1';

    /**
     * Field data was not requested.
     * @var String
     */
    const NOT_REQUESTED = 'E2';

    /**
     * Access to field data denied.
     * @var String
     */
    const ACCESS_DENIED = 'E3';

}
