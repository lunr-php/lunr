<?php

/**
 * This file contains the Resque job dispatcher.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spwn
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spwn;

use \Resque;

/**
 * Resque job dispatcher class.
 *
 * @category   Libraries
 * @package    Spwn
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class ResqueJobDispatcher implements JobDispatcherInterface
{
    /**
     * The Resque instance of this dispatcher.
     * @var Resque
     */
    private $resque;

    /**
     * The token of the last enqueued job.
     * @var String
     */
    private $token;

    /**
     * The queue to enqueue in.
     * @var String
     */
    private $queue;

    /**
     * The status tracking ability of enqueued jobs.
     * @var String
     */
    private $track_status;

    /**
     * Constructor.
     *
     * @param Resque $resque The Resque instance used by this dispatcher
     */
    public function __construct($resque)
    {
        $this->resque       = $resque;
        $this->token        = NULL;
        $this->queue        = 'default_queue';
        $this->track_status = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->resque);
        unset($this->token);
        unset($this->queue);
        unset($this->track_status);
    }

    /**
     * Enqueue a job in php-resque.
     *
     * @param String $job  The job to execute
     * @param array  $args The arguments for the job execution
     *
     * @return void
     */
    public function dispatch($job, $args = NULL)
    {
        $this->token = $this->resque->enqueue($this->queue, $job, $args, $this->track_status);
    }

    /**
     * Returns the token of the last dispatched Resque job.
     *
     * @return String $token The token of the last enqueued job,
     *                       NULL if unproper argument supplied
     */
    public function get_job_id()
    {
        return $this->token;
    }

    /**
     * Sets the queue to dispatch to for this dispatcher.
     *
     * @param String $queue The queue to set for this dispatcher
     *
     * @return ResqueJobDispatcher $self Self-reference
     */
    public function set_queue($queue)
    {
        if(is_string($queue))
        {
            $this->queue = $queue;
        }

        return $this;
    }

    /**
     * Sets whether the status of the dispatched job will be tracked.
     *
     * @param Boolean $track_status The queue to set for this dispatcher
     *
     * @return ResqueJobDispatcher $self Self-reference
     */
    public function set_track_status($track_status)
    {
        if(is_bool($track_status))
        {
            $this->track_status = $track_status;
        }

        return $this;
    }

}

?>
