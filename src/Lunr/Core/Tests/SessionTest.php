<?php

/**
 * This file contains the DatabaseSessionHandlerTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use stdClass;
use Lunr\Core\Session;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Session class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Core\Session
 */
abstract class SessionTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Session class
     * @var Session
     */
    protected $session;

    /**
     * Reflection instance of the Session class
     * @var ReflectionClass
     */
    protected $session_reflection;

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
        $this->session = new Session();

        $this->session_reflection = new ReflectionClass('Lunr\Core\Session');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->session);
        unset($this->session_reflection);
    }

    /**
     * Unit Test Data Provider for invalid SessionHandlers.
     *
     * @return array $handlers Set of invalid session handlers
     */
    public function invalidSessionHandlerProvider()
    {
        $handlers   = array();
        $handlers[] = array('myHandler');
        $handlers[] = array(144);
        $handlers[] = array(TRUE);

        return $handlers;
    }

}

?>
