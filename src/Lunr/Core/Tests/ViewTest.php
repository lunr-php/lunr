<?php

/**
 * This file contains the ViewTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\View;
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
 * @covers     Lunr\Core\View
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
     * Mock instance of the l10nprovider class.
     * @var L10nProvider
     */
    protected $l10nprovider;

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
    public function setUpL10n()
    {
        $this->sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('path', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->request = $this->getMockBuilder('Lunr\Core\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMock('Lunr\Core\Response');

        $this->l10nprovider = $this->getMockBuilder('Lunr\L10n\L10nProvider')
                                   ->disableOriginalConstructor()
                                   ->getMockForAbstractClass();

        $this->view = $this->getMockBuilder('Lunr\Core\View')
                           ->setConstructorArgs(
                               array(&$this->request, &$this->response, &$this->configuration, &$this->l10nprovider)
                             )
                           ->getMockForAbstractClass();

        $this->view_reflection = new ReflectionClass('Lunr\Core\View');
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUpNoL10n()
    {
        $this->sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('path', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->request = $this->getMockBuilder('Lunr\Core\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMock('Lunr\Core\Response');

        $this->l10nprovider = NULL;

        $this->view = $this->getMockBuilder('Lunr\Core\View')
                           ->setConstructorArgs(
                               array(&$this->request, &$this->response, &$this->configuration)
                             )
                           ->getMockForAbstractClass();

        $this->view_reflection = new ReflectionClass('Lunr\Core\View');
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
