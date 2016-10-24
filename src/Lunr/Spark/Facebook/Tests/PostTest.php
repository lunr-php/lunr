<?php

/**
 * This file contains the PostTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Post;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook Post class.
 *
 * @covers Lunr\Spark\Facebook\Post
 */
abstract class PostTest extends LunrBaseTest
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
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas    = $this->getMock('Lunr\Spark\CentralAuthenticationStore');
        $this->http   = $this->getMock('Requests_Session');
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->class = $this->getMockBuilder('Lunr\Spark\Facebook\Post')
                            ->setConstructorArgs([ $this->cas, $this->logger, $this->http ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\Post');
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
    }

    /**
     * Unit test data provider for fields that require an access token.
     *
     * @return array $fields Array of fields.
     */
    public function accessTokenFieldsProvider()
    {
        $fields   = [];
        $fields[] = [ 'id' ];
        $fields[] = [ 'from' ];
        $fields[] = [ 'to' ];
        $fields[] = [ 'message' ];
        $fields[] = [ 'message_tags' ];
        $fields[] = [ 'picture' ];
        $fields[] = [ 'link' ];
        $fields[] = [ 'name' ];
        $fields[] = [ 'caption' ];
        $fields[] = [ 'description' ];
        $fields[] = [ 'source' ];
        $fields[] = [ 'properties' ];
        $fields[] = [ 'icon' ];
        $fields[] = [ 'actions' ];
        $fields[] = [ 'type' ];

        return $fields;
    }

    /**
     * Unit test data provider for fields that require special permissions.
     *
     * @return array $fields Array of fields.
     */
    public function permissionFieldsProvider()
    {
        $fields   = [];
        $fields[] = [ 'privacy', 'read_stream' ];
        $fields[] = [ 'place', 'read_stream' ];
        $fields[] = [ 'story', 'read_stream' ];
        $fields[] = [ 'story_tags', 'read_stream' ];
        $fields[] = [ 'with_tags', 'read_stream' ];
        $fields[] = [ 'object_id', 'read_stream' ];
        $fields[] = [ 'application', 'read_stream' ];
        $fields[] = [ 'created_time', 'read_stream' ];
        $fields[] = [ 'updated_time', 'read_stream' ];
        $fields[] = [ 'shares', 'read_stream' ];
        $fields[] = [ 'include_hidden', 'read_stream' ];
        $fields[] = [ 'status_type', 'read_stream' ];

        return $fields;
    }

}

?>
