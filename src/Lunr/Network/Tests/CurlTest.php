<?php

/**
 * This file contains the CurlTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Network\Curl;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the Curl class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Network\Curl
 */
abstract class CurlTest extends LunrBaseTest
{

    /**
     * Instance of the Curl class.
     * @var Curl
     */
    protected $curl;

    /**
     * Reflection instance of the Curl class.
     * @var ReflectionClass
     */
    protected $curl_reflection;

    /**
     * Runkit simulation code for returning FALSE.
     * @var string
     */
    const CURL_RETURN_FALSE = 'return FALSE;';

    /**
     * Runkit simulation code for returning TRUE.
     * @var string
     */
    const CURL_RETURN_TRUE = 'return TRUE;';

    /**
     * Runkit simulation code for returning error message.
     * @var string
     */
    const CURL_RETURN_ERRMSG = 'return "error";';

    /**
     * Runkit simulation code for returning error code.
     * @var string
     */
    const CURL_RETURN_ERRNO = 'return 10;';

    /**
     * Runkit simulation code for returning the http code.
     * @var string
     */
    const CURL_RETURN_CODE = 'return 404;';

    /**
     * Runkit simulation code for returning info.
     * @var string
     */
    const CURL_RETURN_INFO = 'return [];';

    /**
     * Runkit simulation code for returning a value.
     * @var string
     */
    const CURL_RETURN_VALUE = 'return "value";';

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        if (extension_loaded('curl') === FALSE)
        {
            $this->markTestSkipped('Extension curl is required.');
        }

        $this->reflection = new ReflectionClass('Lunr\Network\Curl');
        $this->class      = new Curl();
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
     * Unit Test Data Provider for invalid Curl options.
     *
     * @return array $options Array of invalid Curl options.
     */
    public function invalidOptionProvider()
    {
        $options   = array();
        $options[] = array('RANDOM_OPTION');
        $options[] = array('C_OPT');
        $options[] = array('CU_OPT');
        $options[] = array('CUR_OPT');
        $options[] = array('curl_OPT');

        return $options;
    }

}

?>
