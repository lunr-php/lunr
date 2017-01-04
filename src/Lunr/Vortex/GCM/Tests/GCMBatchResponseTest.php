<?php

/**
 * This file contains the GCMBatchResponseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Halo\LunrBaseTest;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GCMBatchResponse class.
 *
 * @covers Lunr\Vortex\GCM\GCMBatchResponse
 */
abstract class GCMBatchResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Requests_Response class.
     * @var \Requests_Response
     */
    protected $response;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp()
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->response = $this->getMockBuilder('Requests_Response')->getMock();
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->response);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
