<?php

/**
 * This file contains the UserTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\User;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook User class.
 *
 * @covers Lunr\Spark\Facebook\User
 */
abstract class UserTest extends LunrBaseTest
{

    /**
     * Mock instance of the CentralAuthenticationStore class.
     * @var \Lunr\Spark\CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Mock instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * Mock instance of the Logger class
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
     */
    public function setUp()
    {
        $this->cas      = $this->getMockBuilder('Lunr\Spark\CentralAuthenticationStore')->getMock();
        $this->http     = $this->getMockBuilder('Requests_Session')->getMock();
        $this->logger   = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $this->response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->class = $this->getMockBuilder('Lunr\Spark\Facebook\User')
                            ->setConstructorArgs([ $this->cas, $this->logger, $this->http ])
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
        unset($this->http);
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
