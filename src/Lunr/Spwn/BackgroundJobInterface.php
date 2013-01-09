<?php

/**
 * This file contains an abstract definition for a background job class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spwn
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spwn;

/**
 * Abstract definition for a a background job .
 *
 * @category   Libraries
 * @package    Spwn
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
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
    public function perfom();

    /**
     * Tears down the environment for this job.
     *
     * @return void
     */
    public function tearDown();

}

?>
