<?php

/**
 * This file contains the SessionTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Sphere
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Sphere\Session;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Session class.
 *
 * @covers Lunr\Sphere\Session
 */
abstract class SessionTest extends LunrBaseTest
{

    /**
     * Runkit simulation code that returns true;
     * @var string
     */
    const FUNCTION_RETURN_TRUE = 'return TRUE;';

    /**
     * Runkit simulation code that returns id;
     * @var string
     */
    protected $generate_id_function;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->class                = new Session();
        $this->reflection           = new ReflectionClass('Lunr\Sphere\Session');
        $id                         = 'myId';
        $this->generate_id_function = function ($set_id = NULL) use (&$id) {
            if (!is_null($set_id))
            {
                $id = $set_id;
            }

            if(!is_null($id))
            {
                return $id;
            }else{
                return 'myId';
            }
        };
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit Test Data Provider for invalid SessionHandlers.
     *
     * @return array $handlers Set of invalid session handlers
     */
    public function invalidSessionHandlerProvider()
    {
        $handlers   = [];
        $handlers[] = ['myHandler'];
        $handlers[] = [144];
        $handlers[] = [TRUE];

        return $handlers;
    }

}

?>
