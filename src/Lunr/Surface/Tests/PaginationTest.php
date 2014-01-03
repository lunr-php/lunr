<?php

/**
 * This file contains the PaginationTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Surface\Tests;

use Lunr\Surface\Pagination;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use stdClass;

/**
 * This class contains the tests for the Pagination class.
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Surface\Pagination
 */
abstract class PaginationTest extends LunrBaseTest
{

    /**
     * Mock instance of the Request class.
     * @var Request
     */
    protected $request;

    /**
     * Test Case Constructor.
     *
     * @return void
     */
    public function setUpWithoutCursor()
    {
        $this->request = $this->getMock('Lunr\Corona\RequestInterface');

        $map = array(
            array('base_url', 'http://www.example.com'),
            array('controller', 'controller'),
            array('method', 'method'),
            array('params', array('param1', 'param2'))
        );

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->will($this->returnValueMap($map));

        $this->reflection = new ReflectionClass('Lunr\Surface\Pagination');

        $this->class = new Pagination($this->request);
    }

    /**
     * Test Case Constructor.
     *
     * @return void
     */
    public function setUpWithCursor()
    {
        $this->request = $this->getMock('Lunr\Corona\RequestInterface');

        $map = array(
            array('base_url', 'http://www.example.com'),
            array('controller', 'controller'),
            array('method', 'method'),
            array('params', array('param1', 'param2', '10'))
        );

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->will($this->returnValueMap($map));

        $this->reflection = new ReflectionClass('Lunr\Surface\Pagination');

        $this->class = new Pagination($this->request);
    }

    /**
     * Test Case Destructor.
     */
    public function tearDown()
    {
        unset($this->request);
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Unittest data provider for invalid total items.
     *
     * @return array $values Array of invalid values.
     */
    public function invalidTotalItemProvider()
    {
        $values   = [];
        $values[] = [ 'string' ];
        $values[] = [ TRUE ];
        $values[] = [ NULL ];
        $values[] = [ new stdClass() ];
        $values[] = [ '10' ];
        $values[] = [ 0 ];
        $values[] = [ -10 ];
        $values[] = [ 2.5 ];

        return $values;
    }

    /**
     * Unittest data provider for invalid baseurl values.
     *
     * @return array $values Array of invalid values.
     */
    public function invalidBaseURLProvider()
    {
        $values   = [];
        $values[] = [ TRUE ];
        $values[] = [ NULL ];
        $values[] = [ new stdClass() ];
        $values[] = [ 0 ];
        $values[] = [ 2.5 ];

        return $values;
    }

    /**
     * Unittest data provider for valid buttons.
     *
     * @return array $buttons Array of valid buttons.
     */
    public function validButtonProvider()
    {
        $buttons   = [];
        $buttons[] = [ 'first' ];
        $buttons[] = [ 'previous' ];
        $buttons[] = [ 'next' ];
        $buttons[] = [ 'last' ];

        return $buttons;
    }

}

?>
