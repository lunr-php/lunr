<?php

/**
 * This file contains the L10nHTMLViewTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10nHTMLView;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class tests the setup of the localized view class, as well as the helper methods.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\L10nHTMLView
 */
abstract class L10nHTMLViewTest extends LunrBaseTest
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

        $this->class = $this->getMockBuilder('Lunr\L10n\L10nHTMLView')
                            ->setConstructorArgs([ $this->request, $this->response, $this->configuration, $this->l10nprovider ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\L10n\L10nHTMLView');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->configuration);
        unset($this->request);
        unset($this->response);
        unset($this->l10nprovider);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
