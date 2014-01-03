<?php
/**
 * This file contains the StreamSocketClientTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the StreamSocketClient class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\StreamSocketClient
 */
abstract class StreamSocketClientTest extends LunrBaseTest
{

    /**
     * Runkit simulation code for returning TRUE.
     * @var String
     */
    const STREAM_SOCKET_CLIENT_RETURN_TRUE = 'return TRUE;';

    /**
     * Runkit simulation code for returning FALSE.
     * @var String
     */
    const STREAM_SOCKET_CLIENT_RETURN_FALSE = 'return FALSE;';

    /**
     * Runkit simulation code for returning handle.
     * @var String
     */
    const STREAM_SOCKET_CLIENT_RETURN_HANDLE = 'return fopen("./test.txt", "a");';

    /**
     * Runkit simulation code for returning handle.
     * @var String
     */
    const STREAM_SOCKET_CLIENT_RETURN_OTHER_HANDLE = 'return fopen("./test2.txt", "a");';

    /**
     * Runkit simulation code for returning int.
     * @var String
     */
    const STREAM_SOCKET_CLIENT_RETURN_EIGHT = 'return 8;';

    /**
     * Runkit simulation code for returning int.
     * @var String
     */
    const STREAM_SOCKET_CLIENT_RETURN_STRING = 'return "string";';

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->reflection = new ReflectionClass('Lunr\Network\StreamSocketClient');
        $this->class      = new \Lunr\Network\StreamSocketClient('');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Unit Test Case Provider for valid init time out value provider.
     *
     * @return array $return The valid values for init time out
     */
    public function validInitTimeoutProvider()
    {
        $timeout   = [];
        $timeout[] = [1, 1.0];
        $timeout[] = [1.0, 1.0];
        $timeout[] = [1000, 1000.0];
        $timeout[] = [1000.0, 1000.0];

        return $timeout;
    }

    /**
     * Unit Test Case Provider for invalid init time out value.
     *
     * @return array $return The invalid values for init time out
     */
    public function invalidInitTimeoutProvider()
    {
        $timeout   = [];
        $timeout[] = [FALSE];
        $timeout[] = [NULL];
        $timeout[] = [TRUE];
        $timeout[] = ['str'];
        $timeout[] = ['1234'];

        return $timeout;
    }

    /**
     * Unit Test Case Provider for invalid flag value.
     *
     * @return array $return The invalid values for flag
     */
    public function invalidFlagProvider()
    {
        $flags   = [];
        $flags[] = ['STREAM_PERS'];
        $flags[] = ['STRAM_PERS'];
        $flags[] = ['STREAM_CLIENT'];
        $flags[] = ['STREAM_CLIENT_A_FLAG'];

        return $flags;
    }

}

?>
