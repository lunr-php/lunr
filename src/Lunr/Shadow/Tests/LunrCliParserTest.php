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
        $this->class      = new LunrCliParser($this->logger, 'ab:c;d:;e::', [ 'first', 'second:', 'third;', 'fourth:;', 'fifth::' ]);
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
        $params   = [];
        $params[] = [ '-' ];
        $params[] = [ '--' ];

        return $params;
    }

    /**
     * Unit test data provider for valid parameters.
     *
     * @return array $params Array of valid parameters
     */
    public function validShortParameterProvider()
    {
        $params   = [];
        $params[] = [ 'a', [ 'test.php', '-a' ], [ 'a' => [] ] ];
        $params[] = [ 'a:', [ 'test.php', '-a', 'arg' ], [ 'a' => [ 'arg' ] ] ];
        $params[] = [ 'a::', [ 'test.php', '-a', 'arg1', 'arg2' ], [ 'a' => [ 'arg1', 'arg2' ] ] ];
        $params[] = [ 'a:::', [ 'test.php', '-a', 'arg1', 'arg2', 'arg3' ], [ 'a' => [ 'arg1', 'arg2', 'arg3' ] ] ];
        $params[] = [ 'b;', [ 'test.php', '-b', 'arg' ], [ 'b' => [ 'arg' ] ] ];
        $params[] = [ 'b;;', [ 'test.php', '-b', 'arg1', 'arg2' ], [ 'b' => [ 'arg1', 'arg2' ] ] ];
        $params[] = [ 'b;;;', [ 'test.php', '-b', 'arg1', 'arg2', 'arg3' ], [ 'b' => [ 'arg1', 'arg2', 'arg3' ] ] ];

        return $params;
    }

    /**
     * Unit test data provider for valid parameters.
     *
     * @return array $params Array of valid parameters
     */
    public function validLongParameterProvider()
    {
        $params   = [];
        $params[] = [ [ 'first' ], [ 'test.php', '--first' ], [ 'first' => [] ] ];
        $params[] = [ [ 'first:' ], [ 'test.php', '--first', 'arg' ], [ 'first' => [ 'arg' ] ] ];
        $params[] = [ [ 'first::' ], [ 'test.php', '--first', 'arg1', 'arg2' ], [ 'first' => [ 'arg1', 'arg2' ] ] ];
        $params[] = [ [ 'first:::' ], [ 'test.php', '--first', 'arg1', 'arg2', 'arg3' ], [ 'first' => [ 'arg1', 'arg2', 'arg3' ] ] ];
        $params[] = [ [ 'second;' ], [ 'test.php', '--second', 'arg' ], [ 'second' => [ 'arg' ] ] ];
        $params[] = [ [ 'second;;' ], [ 'test.php', '--second', 'arg1', 'arg2' ], [ 'second' => [ 'arg1', 'arg2' ] ] ];
        $params[] = [ [ 'second;;;' ], [ 'test.php', '--second', 'arg1', 'arg2', 'arg3' ], [ 'second' => [ 'arg1', 'arg2', 'arg3' ] ] ];

        return $params;
    }

}

?>
