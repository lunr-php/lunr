<?php

/**
 * This file contains the FCMResponseTest class.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use Lunr\Vortex\FCM\FCMResponse;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FCMResponse class.
 *
 * @covers Lunr\Vortex\FCM\FCMResponse
 */
abstract class FCMResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the FCMBatchResponse class.
     * @var Lunr\Vortex\FCM\FCMBatchResponse
     */
    protected $batch_response;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp()
    {
        $this->class      = new FCMResponse();
        $this->reflection = new ReflectionClass('Lunr\Vortex\FCM\FCMResponse');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->batch_response);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
