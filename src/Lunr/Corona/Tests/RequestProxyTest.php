<?php

/**
 * This file contains the RequestProxyTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Core\Configuration;
use Lunr\Corona\RequestProxy;
use Lunr\Corona\Request;
use ReflectionClass;
use Lunr\Halo\LunrBaseTest;

/**
 * This class contains the tests for the class class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\RequestProxy
 */
abstract class RequestProxyTest extends LunrBaseTest
{

    /**
     * The Mock instance of the request class.
     * @var RequestInterface
     */
    protected $request;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->request = $this->getMock('Lunr\Corona\RequestInterface');

        $this->class      = new RequestProxy($this->request);
        $this->reflection = new ReflectionClass('Lunr\Corona\RequestProxy');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->request);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit Test Data Provider for request method calls.
     *
     * @return array $values Set of request values
     */
    public function methodCallProvider()
    {
        $values   = array();
        $values[] = array('get_get_data');
        $values[] = array('get_post_data');
        $values[] = array('get_cookie_data');

        return $values;
    }

    /**
     * Unit Test Data Provider for request values.
     *
     * @return array $values Set of request values
     */
    public function requestKeyProvider()
    {
        $values   = array();
        $values[] = array('sapi');
        $values[] = array('host');
        $values[] = array('base_path');
        $values[] = array('protocol');
        $values[] = array('domain');
        $values[] = array('port');
        $values[] = array('host');
        $values[] = array('base_url');

        return $values;
    }

}

?>
