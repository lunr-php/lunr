<?php

/**
 * This file contains the Null job dispatcher.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Spawn
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn;

/**
 * Null dispatcher class.
 */
class NullDispatcher implements JobDispatcherInterface
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        // noop
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // noop
    }

    /**
     * Dispatch a background job.
     *
     * @param string $job  The job to execute
     * @param array  $args The arguments for the job execution
     *
     * @return void
     */
    public function dispatch($job, $args)
    {
        // noop
    }

    /**
     * Returns the job ID of the last background job dispatching, if any.
     *
     * @return void
     */
    public function get_job_id()
    {
        // noop
    }

    /**
     * Sets the queue(s) to dispatch to for this dispatcher.
     *
     * @param mixed $queue The queue or the queues to set for this dispatcher.
     *
     * @return NullDispatcher $self Self-reference
     */
    public function set_queue($queue)
    {
        return $this;
    }

    /**
     * Sets whether the status of the dispatched job will be tracked.
     *
     * @param boolean $track_status The queue to set for this dispatcher
     *
     * @return NullDispatcher $self Self-reference
     */
    public function set_track_status($track_status)
    {
        return $this;
    }

}

?>
