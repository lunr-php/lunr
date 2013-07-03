<?php

/**
 * This file contains the L10nViewTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10nView;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class tests the setup of the localized view class, as well as the helper methods.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\L10nView
 */
abstract class L10nViewTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mock instance of the request class.
     * @var RequestInterface
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
    public function setUp()
    {
        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $this->request = $this->getMock('Lunr\Core\RequestInterface');

        $this->response = $this->getMock('Lunr\Core\Response');

        $this->l10nprovider = $this->getMockBuilder('Lunr\L10n\L10nProvider')
                                   ->disableOriginalConstructor()
                                   ->getMockForAbstractClass();

        $this->view = $this->getMockBuilder('Lunr\L10n\L10nView')
                           ->setConstructorArgs(
                               array($this->request, $this->response, $this->configuration, $this->l10nprovider)
                             )
                           ->getMockForAbstractClass();

        $this->view_reflection = new ReflectionClass('Lunr\L10n\L10nView');
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

}

?>
