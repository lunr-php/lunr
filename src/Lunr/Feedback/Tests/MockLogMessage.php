<?php

/**
 * This file contains a MockLogMessage class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Feedback
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback\Tests;

/**
 * This class contains a mock for a simple log message class.
 */
class MockLogMessage
{

    /**
     * Return a simple test string.
     *
     * @return String $return simple test string
     */
    public function __toString()
    {
        return 'Foo';
    }

}

?>
