<?php

/**
 * Lunr wrapper around the SQLite3 class, that doesn't connect on construct.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3;

use SQLite3;

/**
 * Wrapper class around SQLite3.
 */
class LunrSQLite3 extends SQLite3
{

    /**
     * Contructor.
     */
    public function __construct()
    {
        // empty constructor to override connect on construction.
    }

}

?>
