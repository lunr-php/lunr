<?php

/**
 * This file contains the CallbackMock.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Halo
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Halo;

/**
 * This mock class can be used when one want to mock callback functionality.
 */
class CallbackMock
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        // no-op
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * A test function to be overridden by phpunit's mock funcitonality.
     *
     * @return void
     */
    public function test()
    {
        // no-op
    }

}

?>
