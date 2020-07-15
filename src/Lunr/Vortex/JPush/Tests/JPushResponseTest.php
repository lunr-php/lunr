<?php

/**
 * This file contains the JPushResponseTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use Lunr\Vortex\JPush\JPushResponse;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the JPushResponse class.
 *
 * @covers Lunr\Vortex\JPush\JPushResponse
 */
abstract class JPushResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the JPushBatchResponse class.
     * @var Lunr\Vortex\JPush\JPushBatchResponse
     */
    protected $batch_response;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->batch_response = $this->getMockBuilder('Lunr\Vortex\JPush\JPushBatchResponse')
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $this->class      = new JPushResponse();
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushResponse');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->batch_response);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
