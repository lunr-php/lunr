<?php

/**
 * This file contains the GCMResponseTest class.
 *
 * @package   Lunr\Vortex\GCM
 * @author    Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright 2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use Lunr\Vortex\GCM\GCMResponse;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GCMResponse class.
 *
 * @covers Lunr\Vortex\GCM\GCMResponse
 */
abstract class GCMResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the GCMBatchResponse class.
     * @var Lunr\Vortex\GCM\GCMBatchResponse
     */
    protected $batch_response;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp()
    {
        $this->batch_response = $this->getMockBuilder('Lunr\Vortex\GCM\GCMBatchResponse')
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $this->class      = new GCMResponse();
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');
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
