<?php

/**
 * This file contains the UserTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\User;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook User class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\User
 */
abstract class UserTest extends LunrBaseTest
{

    /**
     * Mock instance of the CentralAuthenticationStore class.
     * @var CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Mock instance of the Curl class.
     * @var Curl
     */
    protected $curl;

    /**
     * Mock instance of the Logger class
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the CurlResponse class.
     * @var CurlResponse
     */
    protected $response;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas      = $this->getMock('Lunr\Spark\CentralAuthenticationStore');
        $this->curl     = $this->getMock('Lunr\Network\Curl');
        $this->logger   = $this->getMock('Psr\Log\LoggerInterface');
        $this->response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->class = $this->getMockBuilder('Lunr\Spark\Facebook\User')
                            ->setConstructorArgs([ $this->cas, $this->logger, $this->curl ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\User');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->cas);
        unset($this->curl);
        unset($this->logger);
        unset($this->response);
    }

    /**
     * Unit test data provider for valid permissions.
     *
     * @return array $permissions Array of permissions
     */
    public function validPermissionsProvider()
    {
        $permissions   = [];
        $permissions[] = [ 'email' ];
        $permissions[] = [[ 'email' ]];
        $permissions[] = [[ 'user_likes', 'friends_likes' ]];
        $permissions[] = [[ 'friends_likes', 'user_likes' ]];

        return $permissions;
    }

    /**
     * Unit test data provider for invalid permissions.
     *
     * @return array $permissions Array of permissions
     */
    public function invalidPermissionsProvider()
    {
        $permissions   = [];
        $permissions[] = [ 'friends_likes', 'friends_likes' ];
        $permissions[] = [[ 'friends_likes' ], 'friends_likes' ];
        $permissions[] = [[ 'friends_likes', 'user_about_me' ], 'friends_likes or user_about_me' ];

        return $permissions;
    }

}

?>
