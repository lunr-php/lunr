<?php

/**
 * This file contains the ApiTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Api;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Api.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Api
 */
abstract class ApiTest extends LunrBaseTest
{

    /**
     * Mock instance of the CentralAuthenticationStore class.
     * @var CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas = $this->getMock('Lunr\Spark\CentralAuthenticationStore');

        $this->class = $this->getMockBuilder('Lunr\Spark\Facebook\Api')
                            ->setConstructorArgs([ $this->cas ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\Api');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->cas);
    }

    /**
     * Unit test data provider for general __get() keys.
     *
     * @return array $keys Array of keys
     */
    public function generalGetKeyProvider()
    {
        $keys   = [];
        $keys[] = [ 'app_id' ];
        $keys[] = [ 'app_secret' ];
        $keys[] = [ 'app_secret_proof' ];
        $keys[] = [ 'access_token' ];

        return $keys;
    }

    /**
     * Unit test data provider for general __set() keys.
     *
     * @return array $keys Array of keys
     */
    public function generalSetKeyProvider()
    {
        $keys   = [];
        $keys[] = [ 'app_id' ];
        $keys[] = [ 'app_secret' ];

        return $keys;
    }

}

?>
