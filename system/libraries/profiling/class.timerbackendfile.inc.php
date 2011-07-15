<?php

/**
 * This file contains the file backend for the Timer class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Profiling
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Profiling;
use Lunr\Libraries\Core\Output;

/**
 * File Backend for the Timer class.
 * The file backend measures the time in microseconds
 * and stores it into a log file on the server.
 *
 * @category   Libraries
 * @package    Profiling
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class TimerBackendFile extends TimerBackend
{

    /**
     * Full path of the Logfile
     * @var String
     */
    private $file;

    /**
     * Array of timers
     * @var array
     */
    private $timers;

    /**
     * Timer counter
     * @var Integer
     */
    private $counter;

    /**
     * Timer thresholds
     * @var array
     */
    private $thresholds;

    /**
     * Constructor.
     */
    public function __construct()
    {
        global $config;
        if (!isset($config['log']['performance']))
        {
            Output::error('Path definition for performance log missing!');
            return FALSE;
        }

        if (!isset($config['performance_log']))
        {
            $config['performance_log'] = 'performance.log';
        }

        $this->file = $config['log']['performance'] . $config['performance_log'];
        $this->timers = array();
        $this->thresholds = array();
        $this->counter = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->timers);
        unset($this->thresholds);
        unset($this->counter);
    }

    /**
     * Start a new Timer.
     *
     * @param Mixed $id        Identifier of the Timer, Numeric by default
     * @param Float $threshold Threshold of the Timer. Result will not be logged
     *                         if it is below the threshold.
     *
     * @return Mixed $return Returns the Specified ID, or the assigned numeric ID,
     *                       or FALSE if a Timer for the chosen ID already exists.
     */
    public function start_new_timer($id = '', $threshold = 0.0)
    {
        if ($id == '')
        {
            $this->timers[$this->counter] = microtime(TRUE);
            $this->thresholds[$this->counter] = $threshold;
            $id = $this->counter;
            ++$this->counter;
        }
        elseif(!isset($this->timers[$id]))
        {
            $this->timers[$id] = microtime(TRUE);
            $this->thresholds[$id] = $threshold;
        }
        else
        {
            return FALSE;
        }

        return $id;
    }

    /**
     * Stop a specified Timer.
     *
     * @param Mixed $id Identifier of the Timer
     *
     * @return Boolean $return FALSE if the Timer doesn't exist, TRUE otherwise
     */
    public function stop_timer($id)
    {
        if (!isset($this->timers[$id]))
        {
            return FALSE;
        }

        $result = microtime(TRUE) - $this->timers[$id];

        if ($result > $this->thresholds[$id])
        {
            $this->store($id, $result, $this->thresholds[$id]);
        }

        unset($this->timers[$id]);
        unset($this->thresholds[$id]);

        return TRUE;
    }

    /**
     * Stop all running Timers.
     *
     * @return void
     */
    public function stop_all_timers()
    {
        foreach ($this->timers as $key => $value)
        {
            $this->stop_timer($key);
        }
    }

    /**
     * Store a Timer result in the log file.
     *
     * @param Mixed $id        Identifier of the Timer
     * @param Float $result    Result of the Timer
     * @param Float $threshold Threshold of the Timer
     *
     * @return void
     */
    private function store($id, $result, $threshold)
    {
        if ($threshold != 0.0)
        {
            $output = "Timer '$id' above configured threshold ($threshold): $result";
        }
        else
        {
            $output = "Timer '$id': $result";
        }

        Output::errorln($output, $this->file);
    }

}

?>
