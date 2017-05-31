<?php

/**
 * This file contains the CurlResponseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Network
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Network\CurlResponse;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the Curl class.
 *
 * @covers Lunr\Network\CurlResponse
 */
abstract class CurlResponseTest extends LunrBaseTest
{

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
     * Runkit simulation code for returning info.
     * @var string
     */
    const CURL_RETURN_INFO = 'return [];';

    /**
     * Testcase Constructor for successful request.
     *
     * @return void
     */
    public function setUpSuccess()
    {
        if (extension_loaded('curl') === FALSE)
        {
            $this->markTestSkipped('Extension curl is required.');
        }

        $this->mock_function('curl_errno', self::CURL_RETURN_ERRNO);
        $this->mock_function('curl_error', self::CURL_RETURN_ERRMSG);
        $this->mock_function('curl_getinfo', self::CURL_RETURN_INFO);

        $this->class      = new CurlResponse('Result', 'handle');
        $this->reflection = new ReflectionClass('Lunr\Network\CurlResponse');
    }

    /**
     * Testcase Constructor for failed request.
     *
     * @return void
     */
    public function setUpError()
    {
        $this->class      = new CurlResponse(NULL, 'handle');
        $this->reflection = new ReflectionClass('Lunr\Network\CurlResponse');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

}

?>
