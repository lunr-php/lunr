<?php

/**
 * This file contains an abstract definition for a background job dispatching class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn;

/**
 * Abstract definition for a a background job dispatcher.
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
interface JobDispatcherInterface
{

    /**
     * Dispatch a background job.
     *
     * @param String $job  The job to execute
     * @param mixed  $args The arguments for the job execution
     *
     * @return void
     */
    public function dispatch($job, $args);

    /**
     * Returns the job ID of the last background job dispatchin, if any.
     *
     * @return String $result The result of the last dispatching if any
     */
    public function get_job_id();

}

?>
