<?php

/**
 * This file contains the ViewTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\View;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class tests the setup of the view class,
 * as well as the helper methods.
 *
 * @covers     Lunr\Corona\View
 */
abstract class ViewTest extends LunrBaseTest
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
     * Mock instance of the sub configuration class.
     * @var Configuration
     */
    protected $sub_configuration;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp()
    {
        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'path', $this->sub_configuration ],
        ];

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMockBuilder('Lunr\Corona\Response')->getMock();

        if (!headers_sent())
        {
            $this->request->expects($this->once())
                ->method('__get')
                ->with('id')
                ->willReturn('962161b27a0141f384c63834ad001adf');
        }

       $this->class = $this->getMockBuilder('Lunr\Corona\View')
                            ->setConstructorArgs(
                               [ $this->request, $this->response, $this->configuration ]
                             )
                           ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Corona\View');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->configuration);
        unset($this->request);
        unset($this->response);
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Unit Test Data Provider for baseurl values.
     *
     * @return array $values Set of test data.
     */
    public function baseUrlProvider()
    {
        $values   = [];
        $values[] = [ 'http://www.example.org/', 'method/param', 'http://www.example.org/method/param' ];
        $values[] = [ 'http://www.example.org/test/', 'method/param', 'http://www.example.org/test/method/param' ];
        return $values;
    }

    /**
     * Unit Test Data Provider for statics values.
     *
     * @return array $values Set of test data.
     */
    public function staticsProvider()
    {
        $values   = [];
        $values[] = [ '/', 'statics', 'image/test.jpg', '/statics/image/test.jpg' ];
        $values[] = [ '/', '/statics', 'image/test.jpg', '/statics/image/test.jpg' ];
        $values[] = [ '/test/', 'statics', 'image/test.jpg', '/test/statics/image/test.jpg' ];
        $values[] = [ '/test/', '/statics', 'image/test.jpg', '/test/statics/image/test.jpg' ];
        return $values;
    }

    /**
     * Unit Test Data Provider for fatal error information.
     *
     * @return array $values Array of mocked fatal error information.
     */
    public function fatalErrorInfoProvider()
    {
        $values   = [];
        $values[] = [ [ 'type' => 1, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 4, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 16, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 64, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 256, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];

        return $values;
    }

    /**
     * Unit Test Data Provider for error information.
     *
     * @return array $values Array of non-fatal error information.
     */
    public function errorInfoProvider()
    {
        $values   = [];
        $values[] = [ NULL ];
        $values[] = [ [ 'type' => 2, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 8, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 32, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 128, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 512, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 1024, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 2048, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 4096, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 8192, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 16384, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];

        return $values;
    }

}

?>
