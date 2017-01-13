<?php

/**
 * This file contains the CentralAuthenticationStoreTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Tests;

use Lunr\Spark\CentralAuthenticationStore;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the CentralAuthenticationStore class.
 *
 * @covers Lunr\Spark\CentralAuthenticationStore
 */
abstract class CentralAuthenticationStoreTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->class      = new CentralAuthenticationStore();
        $this->reflection = new ReflectionClass('Lunr\Spark\CentralAuthenticationStore');
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
