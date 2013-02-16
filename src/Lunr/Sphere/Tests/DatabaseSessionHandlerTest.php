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
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere\Tests;

use PHPUnit_Framework_TestCase;
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
 * @covers     Lunr\Sphere\DatabaseSessionHandler
 */
abstract class DatabaseSessionHandlerTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the DatabaseSessionHandler class
     * @var DatabaseSessionHandler
     */
    protected $dsh;

    /**
     * Reflection instance of the DatabaseSessionHandler class
     * @var ReflectionClass
     */
    protected $dsh_reflection;

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

        $this->dsh = new DatabaseSessionHandler($this->sdao);

        $this->dsh_reflection = new ReflectionClass('Lunr\Sphere\DatabaseSessionHandler');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->dsh);
        unset($this->dsh_reflection);
        unset($this->sdao);
    }

}

?>
