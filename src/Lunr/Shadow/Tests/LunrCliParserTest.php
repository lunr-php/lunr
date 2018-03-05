<?php

/**
 * This file contains the LunrCliParserTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

use Lunr\Shadow\LunrCliParser;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
abstract class LunrCliParserTest extends LunrBaseTest
{

    /**
     * Mock instance of the Console class.
     * @var Console
     */
    protected $console;

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->console = $this->getMockBuilder('Lunr\Shadow\Console')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class      = new LunrCliParser($this->console, 'ab:c;d:;e::', [ 'first', 'second:', 'third;', 'fourth:;', 'fifth::' ]);
        $this->reflection = new ReflectionClass('Lunr\Shadow\LunrCliParser');
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        unset($this->console);
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
