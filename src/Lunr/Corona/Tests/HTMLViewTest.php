<?php

/**
 * This file contains the HTMLViewTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\HTMLView;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class tests the setup of the view class,
 * as well as the helper methods.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\HTMLView
 */
abstract class HTMLViewTest extends LunrBaseTest
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
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp()
    {
        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $this->request = $this->getMock('Lunr\Corona\RequestInterface');

        $this->response = $this->getMock('Lunr\Corona\Response');

        $this->class = $this->getMockBuilder('Lunr\Corona\HTMLView')
                           ->setConstructorArgs([$this->request, $this->response, $this->configuration])
                           ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Corona\HTMLView');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->configuration);
        unset($this->request);
        unset($this->response);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit Test Data Provider for css alternating.
     *
     * @return array $values Set of test data.
     */
    public function cssAlternateProvider()
    {
        $values   = [];
        $values[] = [ 'row', 0, '', 'row_even' ];
        $values[] = [ 'row', 1, '', 'row_odd' ];
        $values[] = [ 'row', 0, 'custom', 'row_custom' ];
        return $values;
    }

}

?>
