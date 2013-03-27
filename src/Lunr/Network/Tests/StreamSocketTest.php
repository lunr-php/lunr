<?php

/**
 * This file contains the StreamSocketTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Network\StreamSocket
 */
abstract class StreamSocketTest extends PHPUnit_Framework_TestCase
{
    /**
     * Instance of the StreamSocket class.
     * @var StreamSocket
     */
    protected $stream_socket;

    /**
     * Reflection instance of the StreamSocket class.
     * @var ReflectionClass
     */
    protected $stream_socket_reflection;

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
        $this->stream_socket_reflection = new ReflectionClass('Lunr\Network\StreamSocket');

        $this->stream_socket = $this->getMockForAbstractClass('Lunr\Network\StreamSocket');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->stream_socket_reflection);
        unset($this->stream_socket);
    }

    /**
     * Unit Test Data Provider for valid property values.
     *
     * @return array $properties Array of valid properties of the StreamSocket class
     */
    public function validPropertyProvider()
    {
        $properties   = array();
        $properties[] = array('errno', 0);
        $properties[] = array('errmsg', '');
        $properties[] = array('meta_data', array());

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
        $wrappers   = array();
        $wrappers[] = array('http', 'method', 'POST');
        $wrappers[] = array('ftp', 'overwrite', FALSE);
        $wrappers[] = array('tcp', 'bla', '127.0.0.1:4321');

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
        $wrappers   = array();
        $wrappers[] = array('beuh', 'method', 'POST');
        $wrappers[] = array('hein', 'overwrite', FALSE);
        $wrappers[] = array('quoi', 'bla', '127.0.0.1:4321');
        $wrappers[] = array(1, 1, 1);
        $wrappers[] = array(0, 1, 1);
        $wrappers[] = array(TRUE, 'TRUE', 'TRUE');
        $wrappers[] = array(FALSE, 'FALSE', 'FALSE');
        $wrappers[] = array(NULL, 'NULL', 'NULL');

        return $wrappers;
    }

    /**
     * Unit Test Data Provider for invalid context options values.
     *
     * @return array $options The invalid options values
     */
    public function invalidOptionsProvider()
    {
        $options   = array();
        $options[] = array('str');
        $options[] = array(0);
        $options[] = array(1);
        $options[] = array(-1);
        $options[] = array(37);
        $options[] = array(NULL);
        $options[] = array(FALSE);
        $options[] = array(TRUE);

        return $options;
    }

    /**
     * Unit Test Data Povider for valid blocking values.
     *
     * @return array $blockings The array of valid blocking values
     */
    public function validBlockingProvider()
    {
        $blockings   = array();
        $blockings[] = array(TRUE);
        $blockings[] = array(FALSE);

        return $blockings;
    }

    /**
     * Unit Test Data Povider for invalid blocking values.
     *
     * @return array $blockings The array of invalid blocking values
     */
    public function invalidBlockingProvider()
    {
        $blockings   = array();
        $blockings[] = array(0);
        $blockings[] = array(1);
        $blockings[] = array(-1);
        $blockings[] = array(2);
        $blockings[] = array(1000);
        $blockings[] = array(39);
        $blockings[] = array('1');
        $blockings[] = array('str');
        $blockings[] = array(0.5);
        $blockings[] = array(3.9);
        $blockings[] = array(-4.7);
        $blockings[] = array(NULL);

        return $blockings;
    }

    /**
     * Unit Test Data Provider for valid timeout values.
     *
     * @return array $timeouts The array of valid timeout values
     */
    public function validTimeoutProvider()
    {
        $timeouts   = array();
        $timeouts[] = array(999, 999);
        $timeouts[] = array(1, 1);
        $timeouts[] = array(0, 1);
        $timeouts[] = array(10, 12);
        $timeouts[] = array(100, 1);
        $timeouts[] = array(1000, 500);
        $timeouts[] = array(0, NULL);

        return $timeouts;
    }

    /**
     * Unit Test Data Provider for invalid timeout values.
     *
     * @return array $timeouts The array of invalid timeout values
     */
    public function invalidTimeoutProvider()
    {
        $timeouts   = array();
        $timeouts[] = array('0', NULL);
        $timeouts[] = array('1', '1');
        $timeouts[] = array(-1, -1);
        $timeouts[] = array(-10, -10);
        $timeouts[] = array( '100', -100);
        $timeouts[] = array(26.87, 52.87);
        $timeouts[] = array(NULL, NULL);
        $timeouts[] = array(FALSE, FALSE);
        $timeouts[] = array(TRUE, TRUE);

        return $timeouts;
    }

    /**
     * Unit Test Data Provider for invalid notification callback.
     *
     * @return array $timeouts The array of invalid notification callback value
     */
    public function invalidNotificationCallBackProvider()
    {
        $callbacks   = array();
        $callbacks[] = array(FALSE);
        $callbacks[] = array(TRUE);
        $callbacks[] = array(0);
        $callbacks[] = array('callback');
        $callbacks[] = array($this, 'nocallback');

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
