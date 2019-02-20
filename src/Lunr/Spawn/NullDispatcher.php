<?php

/**
 * This file contains the Null job dispatcher.
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
     * Dispatch a delayed job.
     *
     * @param integer $seconds Amount of seconds in the future
     * @param string  $job     The job to execute
     * @param array   $args    The arguments for the job execution
     *
     * @return void
     */
    public function dispatch_in($seconds, $job, $args = NULL)
    {
        // no-op
    }

    /**
     * Dispatch a delayed job.
     *
     * @param DateTime|integer $time Timestamp or DateTime object of when the job should execute
     * @param string           $job  The job to execute
     * @param array            $args The arguments for the job execution
     *
     * @return void
     */
    public function dispatch_at($time, $job, $args = NULL)
    {
        // no-op
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
