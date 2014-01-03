<?php

/**
 * This file contains the StreamSocketTest class.
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
 * This class contains test methods for the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\StreamSocket
 */
abstract class StreamSocketTest extends LunrBaseTest
{

    /**
     * Runkit simulation code for returning FALSE.
     * @var string
     */
    const STREAM_SOCKET_RETURN_FALSE = 'return FALSE;';

    /**
     * Runkit simulation code for returning TRUE.
     * @var string
     */
    const STREAM_SOCKET_RETURN_TRUE = 'return TRUE;';

    /**
     * Runkit simulation code for returning NULL.
     * @var string
     */
    const STREAM_SOCKET_RETURN_NULL = 'return NULL;';

    /**
     * Runkit simulation code for returning 1.
     * @var string
     */
    const STREAM_SOCKET_RETURN_ONE = 'return 1;';

    /**
     * Runkit simulation code for returning 0.
     * @var string
     */
    const STREAM_SOCKET_RETURN_ZERO = 'return 0;';

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->reflection = new ReflectionClass('Lunr\Network\StreamSocket');
        $this->class      = $this->getMockForAbstractClass('Lunr\Network\StreamSocket');
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
     * Unit Test Data Provider for valid property values.
     *
     * @return array $properties Array of valid properties of the StreamSocket class
     */
    public function validPropertyProvider()
    {
        $properties   = [];
        $properties[] = ['errno', 0];
        $properties[] = ['errmsg', ''];
        $properties[] = ['meta_data', []];

        return $properties;
    }

    /**
     * Unit Test data Provider for valid wrapper values.
     *
     * @return array $wrappers Array of valid wrappers of the stream socket class
     *                         with option and value
     */
    public function validWrapperProvider()
    {
        $wrappers   = [];
        $wrappers[] = ['http', 'method', 'POST'];
        $wrappers[] = ['ftp', 'overwrite', FALSE];
        $wrappers[] = ['tcp', 'bla', '127.0.0.1:4321'];

        return $wrappers;
    }

    /**
     * Unit Test Data Provider for valid wrapper values.
     *
     * @return array $wrappers Array of valid wrappers of the stream socket class
     *                         with option and value
     */
    public function invalidWrapperProvider()
    {
        $wrappers   = [];
        $wrappers[] = ['beuh', 'method', 'POST'];
        $wrappers[] = ['hein', 'overwrite', FALSE];
        $wrappers[] = ['quoi', 'bla', '127.0.0.1:4321'];
        $wrappers[] = [1, 1, 1];
        $wrappers[] = [0, 1, 1];
        $wrappers[] = [TRUE, 'TRUE', 'TRUE'];
        $wrappers[] = [FALSE, 'FALSE', 'FALSE'];
        $wrappers[] = [NULL, 'NULL', 'NULL'];

        return $wrappers;
    }

    /**
     * Unit Test Data Provider for invalid context options values.
     *
     * @return array $options The invalid options values
     */
    public function invalidOptionsProvider()
    {
        $options   = [];
        $options[] = ['str'];
        $options[] = [0];
        $options[] = [1];
        $options[] = [-1];
        $options[] = [37];
        $options[] = [NULL];
        $options[] = [FALSE];
        $options[] = [TRUE];

        return $options;
    }

    /**
     * Unit Test Data Povider for valid blocking values.
     *
     * @return array $blockings The array of valid blocking values
     */
    public function validBlockingProvider()
    {
        $blockings   = [];
        $blockings[] = [TRUE];
        $blockings[] = [FALSE];

        return $blockings;
    }

    /**
     * Unit Test Data Povider for invalid blocking values.
     *
     * @return array $blockings The array of invalid blocking values
     */
    public function invalidBlockingProvider()
    {
        $blockings   = [];
        $blockings[] = [0];
        $blockings[] = [1];
        $blockings[] = [-1];
        $blockings[] = [2];
        $blockings[] = [1000];
        $blockings[] = [39];
        $blockings[] = ['1'];
        $blockings[] = ['str'];
        $blockings[] = [0.5];
        $blockings[] = [3.9];
        $blockings[] = [-4.7];
        $blockings[] = [NULL];

        return $blockings;
    }

    /**
     * Unit Test Data Provider for valid timeout values.
     *
     * @return array $timeouts The array of valid timeout values
     */
    public function validTimeoutProvider()
    {
        $timeouts   = [];
        $timeouts[] = [999, 999];
        $timeouts[] = [1, 1];
        $timeouts[] = [0, 1];
        $timeouts[] = [10, 12];
        $timeouts[] = [100, 1];
        $timeouts[] = [1000, 500];
        $timeouts[] = [0, NULL];

        return $timeouts;
    }

    /**
     * Unit Test Data Provider for invalid timeout values.
     *
     * @return array $timeouts The array of invalid timeout values
     */
    public function invalidTimeoutProvider()
    {
        $timeouts   = [];
        $timeouts[] = ['0', NULL];
        $timeouts[] = ['1', '1'];
        $timeouts[] = [-1, -1];
        $timeouts[] = [-10, -10];
        $timeouts[] = ['100', -100];
        $timeouts[] = [26.87, 52.87];
        $timeouts[] = [NULL, NULL];
        $timeouts[] = [FALSE, FALSE];
        $timeouts[] = [TRUE, TRUE];

        return $timeouts;
    }

    /**
     * Unit Test Data Provider for invalid notification callback.
     *
     * @return array $timeouts The array of invalid notification callback value
     */
    public function invalidNotificationCallBackProvider()
    {
        $callbacks   = [];
        $callbacks[] = [FALSE];
        $callbacks[] = [TRUE];
        $callbacks[] = [0];
        $callbacks[] = ['callback'];
        $callbacks[] = [$this, 'nocallback'];

        return $callbacks;
    }

    /**
     * Test function for callback test purpose.
     *
     * @return void
     */
    public function notification()
    {

    }

}

?>
