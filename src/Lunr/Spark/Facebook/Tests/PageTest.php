<?php

/**
 * This file contains the PageTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Page;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook Page class.
 *
 * @covers Lunr\Spark\Facebook\Page
 */
abstract class PageTest extends LunrBaseTest
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

        $this->class = $this->getMockBuilder('Lunr\Spark\Facebook\Page')
                            ->setConstructorArgs([ $this->cas, $this->logger, $this->http ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\Page');
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
     * Unit test data provider for public fields.
     *
     * @return array $fields Array of fields.
     */
    public function publicFieldsProvider()
    {
        $fields   = [];
        $fields[] = [ 'id' ];
        $fields[] = [ 'name' ];
        $fields[] = [ 'link' ];
        $fields[] = [ 'category' ];
        $fields[] = [ 'is_published' ];
        $fields[] = [ 'can_post' ];
        $fields[] = [ 'likes' ];
        $fields[] = [ 'location' ];
        $fields[] = [ 'phone' ];
        $fields[] = [ 'checkins' ];
        $fields[] = [ 'picture' ];
        $fields[] = [ 'cover' ];
        $fields[] = [ 'website' ];
        $fields[] = [ 'talking_about_count' ];
        $fields[] = [ 'global_brand_parent_page' ];
        $fields[] = [ 'were_here_count' ];
        $fields[] = [ 'company_overview' ];
        $fields[] = [ 'hours' ];

        return $fields;
    }

    /**
     * Unit test data provider for non Array values.
     *
     * @return array $values Array of non array values
     */
    public function nonArrayProvider()
    {
        $values   = [];
        $values[] = [ 'string' ];
        $values[] = [ 0 ];
        $values[] = [ 1.1 ];
        $values[] = [ NULL ];
        $values[] = [ FALSE ];
        $values[] = [ new \stdClass() ];

        return $values;
    }

}

?>
