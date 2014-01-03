<?php

/**
 * This file contains the SessionTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use stdClass;
use Lunr\Sphere\Session;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Session class.
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Sphere\Session
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
    const FUNCTION_GENERATE_ID = '  static $id;
                                    $args = func_get_args();
                                    if(!is_null($args)&&isset($args[0])){
                                        $id = $args[0];
                                    }
                                    if(!is_null($id)){
                                       return $id;
                                    }else{
                                        return \'myId\';
                                    }';

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->class      = new Session();
        $this->reflection = new ReflectionClass('Lunr\Sphere\Session');
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
