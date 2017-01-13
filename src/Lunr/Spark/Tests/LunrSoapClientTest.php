<?php

/**
 * This file contains the LunrSoapClientTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Tests;

use Lunr\Spark\LunrSoapClient;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the LunrSoapClient class.
 *
 * @covers Lunr\Spark\LunrSoapClient
 */
abstract class LunrSoapClientTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->class      = new LunrSoapClient();
        $this->reflection = new ReflectionClass('Lunr\Spark\LunrSoapClient');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        parent::tearDown();
    }

}
