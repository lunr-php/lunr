<?php

/**
 * This file contains the DatabaseSessionHandlerTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use stdClass;
use Lunr\Sphere\DatabaseSessionHandler;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the DatabaseSessionHandler class.
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Sphere\DatabaseSessionHandler
 */
abstract class DatabaseSessionHandlerTest extends LunrBaseTest
{

    /**
     * Mock instance of the Session DAO class.
     * @var SessionDAO
     */
    protected $sdao;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->sdao = $this->getMockBuilder('Lunr\Sphere\SessionDAO')
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->class      = new DatabaseSessionHandler($this->sdao);
        $this->reflection = new ReflectionClass('Lunr\Sphere\DatabaseSessionHandler');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->sdao);
        unset($this->reflection);
        unset($this->class);
    }

}

?>
