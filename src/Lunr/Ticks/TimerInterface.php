<?php

/**
 * This file contains an interface for Timers.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Ticks;

/**
 * This interface defines the timer primitives.
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface TimerInterface
{

    /**
     * Start a new timer.
     *
     * @param Mixed $id Identifier of the timer, numeric by default
     *
     * @return Mixed $return Returns the ID of the created timer or FALSE if it couldn't be created.
     */
    public function start($id = NULL);

    /**
     * Add tags to a timer.
     *
     * @param Mixed $id   Identifier of the timer
     * @param Array $tags Tags to associate with the timer
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public function add_tags($id, $tags);

    /**
     * Stop a specific timer.
     *
     * @param Mixed $id Identifier of the timer
     *
     * @return Boolean $return FALSE if the timer couldn't be stopped, TRUE otherwise
     */
    public function stop($id);

    /**
     * Stop all running timers.
     *
     * @return Boolean $return FALSE if the timers couldn't be stopped, TRUE otherwise
     */
    public function stop_all();

    /**
     * Delete a timer and its result.
     *
     * @param Mixed $id Identifier of the timer
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public function delete($id);

    /**
     * Store timer results.
     *
     * @return void
     */
    public function flush();

}

?>
