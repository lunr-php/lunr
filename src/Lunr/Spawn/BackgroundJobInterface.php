<?php

/**
 * This file contains an abstract definition for a background job class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Spawn
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn;

/**
 * Abstract definition for a a background job .
 */
interface BackgroundJobInterface
{

    /**
     * Sets up the environment for this job.
     *
     * @return void
     */
    public function setUp();

    /**
     * Performs the background job.
     *
     * @return void
     */
    public function perform();

    /**
     * Tears down the environment for this job.
     *
     * @return void
     */
    public function tearDown();

}

?>
