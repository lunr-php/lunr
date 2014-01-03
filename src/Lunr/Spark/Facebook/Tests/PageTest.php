<?php

/**
 * This file contains the PageTest class.
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

use Lunr\Spark\Facebook\Page;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook Page class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Page
 */
abstract class PageTest extends LunrBaseTest
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

        $this->class = $this->getMockBuilder('Lunr\Spark\Facebook\Page')
                            ->setConstructorArgs([ $this->cas, $this->logger, $this->curl ])
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
        unset($this->curl);
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
