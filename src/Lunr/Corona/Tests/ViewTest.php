<?php

/**
 * This file contains the ViewTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\View;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class tests the setup of the view class,
 * as well as the helper methods.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\View
 */
abstract class ViewTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mock instance of the request class.
     * @var Request
     */
    protected $request;

    /**
     * Mock instance of the response class.
     * @var Response
     */
    protected $response;

    /**
     * Mock instance of the configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the sub configuration class.
     * @var Configuration
     */
    protected $sub_configuration;

    /**
     * Reflection instance of the View class.
     * @var ReflectionClass
     */
    protected $view_reflection;

    /**
     * Mock instance of the View class.
     * @var View
     */
    protected $view;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp()
    {
        $this->sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('path', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMock('Lunr\Corona\Response');

        $this->view = $this->getMockBuilder('Lunr\Corona\View')
                           ->setConstructorArgs(
                               array($this->request, $this->response, $this->configuration)
                             )
                           ->getMockForAbstractClass();

        $this->view_reflection = new ReflectionClass('Lunr\Corona\View');
    }

    /**
     * TestCase Destructor.
     */
    protected function tearDown()
    {
        unset($this->configuration);
        unset($this->request);
        unset($this->response);
        unset($this->view);
        unset($this->view_reflection);
    }

    /**
     * Unit Test Data Provider for baseurl values.
     *
     * @return array $values Set of test data.
     */
    public function baseUrlProvider()
    {
        $values   = array();
        $values[] = array('http://www.example.org/', 'method/param', 'http://www.example.org/method/param');
        $values[] = array('http://www.example.org/test/', 'method/param', 'http://www.example.org/test/method/param');
        return $values;
    }

    /**
     * Unit Test Data Provider for statics values.
     *
     * @return array $values Set of test data.
     */
    public function staticsProvider()
    {
        $values   = array();
        $values[] = array('/', 'statics', 'image/test.jpg', '/statics/image/test.jpg');
        $values[] = array('/', '/statics', 'image/test.jpg', '/statics/image/test.jpg');
        $values[] = array('/test/', 'statics', 'image/test.jpg', '/test/statics/image/test.jpg');
        $values[] = array('/test/', '/statics', 'image/test.jpg', '/test/statics/image/test.jpg');
        return $values;
    }

    /**
     * Unit Test Data Provider for css alternating.
     *
     * @return array $values Set of test data.
     */
    public function cssAlternateProvider()
    {
        $values   = array();
        $values[] = array('row', 0, '', 'row_even');
        $values[] = array('row', 1, '', 'row_odd');
        $values[] = array('row', 0, 'custom', 'row_custom');
        return $values;
    }

}

?>
