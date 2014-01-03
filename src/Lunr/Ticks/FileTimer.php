<?php

/**
 * This file contains a timer implementation storing results in a file.
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
 * Timer class, storing results in a file.
 *
 * @category   Libraries
 * @package    Ticks
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class FileTimer implements TimerInterface
{

    /**
     * Array of timers.
     * @var Array
     */
    protected $timers;

    /**
     * Timer counter.
     * @var Integer
     */
    protected $counter;

    /**
     * String representation of the request.
     * @var String
     */
    protected $request;

    /**
     * Instance of the DateTime class.
     * @var DateTime
     */
    protected $datetime;

    /**
     * File Object for storing the results.
     * @var SplFileObject
     */
    protected $file;

    /**
     * Constructor.
     *
     * @param RequestInterface $request  Shared instance of the Request class.
     * @param DateTime         $datetime Instance of the DateTime class.
     * @param SplFileObject    $file     File where the timer results should be stored in.
     */
    public function __construct($request, $datetime, $file)
    {
        $this->timers  = array();
        $this->counter = 0;
        $this->file    = $file;

        $this->datetime = $datetime;
        $this->datetime->set_datetime_format('%Y-%m-%d %H:%M:%S');

        if ($request->call != NULL)
        {
            $this->request = $request->call . ': ';
        }
        else
        {
            $this->request = '';
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->timers);
        unset($this->counter);
        unset($this->file);
    }

    /**
     * Start a new timer.
     *
     * @param Mixed $id Identifier of the timer, numeric by default
     *
     * @return Mixed $return Returns the ID of the created timer or FALSE if it couldn't be created.
     */
    public function start($id = NULL)
    {
        $index = is_null($id) ? $this->counter++ : $id;

        if (isset($this->timers[$index]))
        {
            return FALSE;
        }

        $this->timers[$index]            = array();
        $this->timers[$index]['start']   = microtime(TRUE);
        $this->timers[$index]['stop']    = 0;
        $this->timers[$index]['stopped'] = FALSE;
        $this->timers[$index]['tags']    = array();

        return $index;
    }

    /**
     * Add tags to a timer.
     *
     * @param Mixed $id   Identifier of the timer
     * @param Array $tags Tags to associate with the timer
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public function add_tags($id, $tags)
    {
        if (!isset($this->timers[$id]) || !is_array($tags))
        {
            return FALSE;
        }

        $set = array_unique(array_merge($this->timers[$id]['tags'], $tags));

        if (empty($set))
        {
            return FALSE;
        }

        $this->timers[$id]['tags'] = $set;

        return TRUE;
    }

    /**
     * Stop a specific timer.
     *
     * @param Mixed $id Identifier of the timer
     *
     * @return Boolean $return FALSE if the timer couldn't be stopped, TRUE otherwise
     */
    public function stop($id)
    {
        if (!isset($this->timers[$id]))
        {
            return FALSE;
        }

        if ($this->timers[$id]['stopped'] !== TRUE)
        {
            $this->timers[$id]['stop']    = microtime(TRUE);
            $this->timers[$id]['stopped'] = TRUE;
        }

        return TRUE;
    }

    /**
     * Stop all running timers.
     *
     * @return Boolean $return FALSE if the timers couldn't be stopped, TRUE otherwise
     */
    public function stop_all()
    {
        foreach ($this->timers as &$timer)
        {
            if ($timer['stopped'] === FALSE)
            {
                $timer['stop']    = microtime(TRUE);
                $timer['stopped'] = TRUE;
            }
        }

        unset($timer);

        return TRUE;
    }

    /**
     * Delete a timer and its result.
     *
     * @param Mixed $id Identifier of the timer
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public function delete($id)
    {
        if (!isset($this->timers[$id]))
        {
            return FALSE;
        }

        unset($this->timers[$id]);

        return TRUE;
    }

    /**
     * Store timer results.
     *
     * @return void
     */
    public function flush()
    {
        $string = '';
        $prefix = '[' . $this->datetime->get_datetime() . ']: ';

        foreach ($this->timers as $key => &$timer)
        {
            if ($timer['stopped'] === FALSE)
            {
                continue;
            }

            $time = $timer['stop'] - $timer['start'];
            $tags = implode(',', $timer['tags']);

            $string .= $prefix . $this->request . "Timer '$key': $time µs; Tags: $tags\n";

            unset($this->timers[$key]);
        }

        unset($timer);

        if ($string !== '')
        {
            $this->file->fwrite($string);
        }
    }

}

?>
