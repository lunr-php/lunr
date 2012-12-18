<?php

/**
 * This file contains a Mock class for Resque Class
 * used by the Unit tests.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spwn
 * @subpackage Mocks
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Mocks\Libraries\Spwn;

/**
 * Resque Mock class
 *
 * @category   Libraries
 * @package    spwn
 * @subpackage Mocks
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class MockResque
{

    /**
     * Mock the enqueue method of Resque.
     *
     * @param String  $queue       The queue for resque enqueuing
     * @param String  $class       The job to execute
     * @param array   $args        The arguments of the job
     * @param Boolean $trackStatus Whether to track or not the the status of the job
     *
     * @return String $return The id of the job
     */
    public static function enqueue($queue, $class, $args = null, $trackStatus = false)
    {
        return 'TOKEN';
    }
}

?>
