<?php

/**
 * This file contains the ViewTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class tests the setup of the view class,
 * as well as the helper methods.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\View
 */
class ViewTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mock instance of the request class.
     * @var Request
     */
    private $request;

    /**
     * Mock instance of the response class.
     * @var Response
     */
    private $response;

    /**
     * Mock instance of the configuration class.
     * @var Configuration
     */
    private $configuration;

    /**
     * Mock instance of the sub configuration class.
     * @var Configuration
     */
    private $sub_configuration;

    /**
     * Mock instance of the l10nprovider class.
     * @var L10nProvider
     */
    private $l10nprovider;

    /**
     * Reflection instance of the View class.
     * @var ReflectionClass
     */
    private $view_reflection;

    /**
     * Mock instance of the View class.
     * @var View
     */
    private $view;

    /**
     * TestCase Constructor.
     */
    protected function setUp()
    {
        $this->sub_configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $map = array(
            array('path', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->request = $this->getMockBuilder('Lunr\Libraries\Core\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMock('Lunr\Libraries\Core\Response');
        $this->l10nprovider = $this->getMockBuilder('Lunr\Libraries\L10n\L10nProvider')
                                   ->disableOriginalConstructor()
                                   ->getMockForAbstractClass();

        $this->view = $this->getMockBuilder('Lunr\Libraries\Core\View')
                           ->setConstructorArgs(
                               array(&$this->request, &$this->response, &$this->configuration, &$this->l10nprovider)
                             )
                           ->getMockForAbstractClass();

        $this->view_reflection = new ReflectionClass('Lunr\Libraries\Core\View');
    }

    /**
     * TestCase Destructor.
     */
    protected function tearDown()
    {
        unset($this->configuration);
        unset($this->request);
        unset($this->response);
        unset($this->l10nprovider);
        unset($this->view);
        unset($this->view_reflection);
    }

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly()
    {
        $property = $this->view_reflection->getProperty('request');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->request, $property->getValue($this->view));
        $this->assertSame($this->request, $property->getValue($this->view));
    }

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly()
    {
        $property = $this->view_reflection->getProperty('response');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->response, $property->getValue($this->view));
        $this->assertSame($this->response, $property->getValue($this->view));
    }

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly()
    {
        $property = $this->view_reflection->getProperty('configuration');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->configuration, $property->getValue($this->view));
        $this->assertSame($this->configuration, $property->getValue($this->view));
    }

    /**
     * Test that the l10nprovider class is set correctly.
     */
    public function testL10nProviderSetCorrectly()
    {
        $property = $this->view_reflection->getProperty('l10n');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->l10nprovider, $property->getValue($this->view));
        $this->assertSame($this->l10nprovider, $property->getValue($this->view));
    }

    /**
     * Tests the base_url method of the View class.
     *
     * @param String $baseurl baseurl value
     * @param String $path    path to append to the baseurl
     * @param String $result  expected combined result
     *
     * @dataProvider baseUrlProvider
     * @covers       Lunr\Libraries\Core\View::base_url
     */
    public function testBaseUrl($baseurl, $path, $result)
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->will($this->returnValue($baseurl));

        $method = $this->view_reflection->getMethod('base_url');
        $method->setAccessible(TRUE);

        $this->assertEquals($result, $method->invokeArgs($this->view, array($path)));
    }

    /**
     * Tests the statics method of the View class.
     *
     * @param String $base    basepath value
     * @param String $statics path to statics
     * @param String $path    path to append to the statics path
     * @param String $result  expected combined result
     *
     * @dataProvider staticsProvider
     * @covers       Lunr\Libraries\Core\View::statics
     */
    public function testStatics($base, $statics, $path, $result)
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->will($this->returnValue($base));
        $this->sub_configuration->expects($this->once())
                                ->method('offsetGet')
                                ->will($this->returnValue($statics));

        $method = $this->view_reflection->getMethod('statics');
        $method->setAccessible(TRUE);

        $this->assertEquals($result, $method->invokeArgs($this->view, array($path)));
    }

    /**
     * Tests the css_alternate method of the View class.
     *
     * @param String $basename         css rule basename
     * @param String $alternation_hint hint on whether to use 'even' or 'odd'
     * @param String $suffix           custom suffix instead of 'even' or 'odd'
     * @param String $result           expected combined result
     *
     * @dataProvider cssAlternateProvider
     * @covers       Lunr\Libraries\Core\View::css_alternate
     */
    public function testCssAlternate($basename, $alternation_hint, $suffix, $result)
    {
        $method = $this->view_reflection->getMethod('css_alternate');
        $method->setAccessible(TRUE);

        $this->assertEquals($result, $method->invokeArgs($this->view, array($basename, $alternation_hint, $suffix)));
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
