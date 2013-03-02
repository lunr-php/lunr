<?php

/**
 * This file contains the LunrCliParserTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

use Lunr\Shadow\LunrCliParser;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the LunrCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\LunrCliParser
 */
abstract class LunrCliParserTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the LunrCliParser class.
     * @var LunrCliParser
     */
    protected $class;

    /**
     * Reflection instance of the LunrCliParser class.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->logger     = $this->getMock('Psr\Log\LoggerInterface');
        $this->class      = new LunrCliParser($this->logger, 'ab:c;d:;e::', array('first', 'second:', 'third;', 'fourth:;', 'fifth::'));
        $this->reflection = new ReflectionClass('Lunr\Shadow\LunrCliParser');
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit test data provider for invalid parameters.
     *
     * @return array $params Array of invalid parameters
     */
    public function invalidParameterProvider()
    {
        $params   = array();
        $params[] = array('-');
        $params[] = array('--');

        return $params;
    }

    /**
     * Unit test data provider for valid parameters.
     *
     * @return array $params Array of valid parameters
     */
    public function validShortParameterProvider()
    {
        $params   = array();
        $params[] = array('a', array('test.php', '-a'), array('a' => array()));
        $params[] = array('a:', array('test.php', '-a', 'arg'), array('a' => array('arg')));
        $params[] = array('a::', array('test.php', '-a', 'arg1', 'arg2'), array('a' => array('arg1', 'arg2')));
        $params[] = array('a:::', array('test.php', '-a', 'arg1', 'arg2', 'arg3'), array('a' => array('arg1', 'arg2', 'arg3')));
        $params[] = array('b;', array('test.php', '-b', 'arg'), array('b' => array('arg')));
        $params[] = array('b;;', array('test.php', '-b', 'arg1', 'arg2'), array('b' => array('arg1', 'arg2')));
        $params[] = array('b;;;', array('test.php', '-b', 'arg1', 'arg2', 'arg3'), array('b' => array('arg1', 'arg2', 'arg3')));

        return $params;
    }

    /**
     * Unit test data provider for valid parameters.
     *
     * @return array $params Array of valid parameters
     */
    public function validLongParameterProvider()
    {
        $params   = array();
        $params[] = array(array('first'), array('test.php', '--first'), array('first' => array()));
        $params[] = array(array('first:'), array('test.php', '--first', 'arg'), array('first' => array('arg')));
        $params[] = array(array('first::'), array('test.php', '--first', 'arg1', 'arg2'), array('first' => array('arg1', 'arg2')));
        $params[] = array(array('first:::'), array('test.php', '--first', 'arg1', 'arg2', 'arg3'), array('first' => array('arg1', 'arg2', 'arg3')));
        $params[] = array(array('second;'), array('test.php', '--second', 'arg'), array('second' => array('arg')));
        $params[] = array(array('second;;'), array('test.php', '--second', 'arg1', 'arg2'), array('second' => array('arg1', 'arg2')));
        $params[] = array(array('second;;;'), array('test.php', '--second', 'arg1', 'arg2', 'arg3'), array('second' => array('arg1', 'arg2', 'arg3')));

        return $params;
    }

}

?>
