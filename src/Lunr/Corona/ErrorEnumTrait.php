<?php

/**
 * This file contains a trait for handling error enums.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Enums
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Date/Time related functions
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Enums
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
trait ErrorEnumTrait
{

    /**
     * Set of error enums.
     * @var array
     */
    protected $error;

    /**
     * Store a set of error enums.
     *
     * @param array &$enums An array of error enums
     *
     * @return void
     */
    public function set_error_enums(&$enums)
    {
        $this->error =& $enums;
    }

}

?>
