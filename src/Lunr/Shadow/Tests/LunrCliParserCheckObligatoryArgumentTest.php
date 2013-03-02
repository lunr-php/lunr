<?php

/**
 * This file contains the LunrCliParserCheckObligatoryArgumentTest class.
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

/**
 * This class contains test methods for check_arguments() in the LunrCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\LunrCliParser
 */
class LunrCliParserCheckObligatoryArgumentTest extends LunrCliParserTest
{

    /**
     * Test that check_argument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithOneArg()
    {
        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '-b', 'arg'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('b' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b:'));

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithTwoArgs()
    {
        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '-e', 'arg1', 'arg2'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('e' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $value = $method->invokeArgs($this->class, array('e', 1, 0, 'e::'));

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsFirstArgumentToAst()
    {
        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '-b', 'arg'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('b' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->class, array('b', 1, 0, 'b:'));

        $value = $ast->getValue($this->class);

        $this->assertCount(1, $value['b']);
        $this->assertEquals(array('arg'), $value['b']);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsSecondArgumentToAst()
    {
        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '-e', 'arg1', 'arg2'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('e' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->class, array('e', 1, 0, 'e::'));

        $value = $ast->getValue($this->class);

        $this->assertCount(2, $value['e']);
        $this->assertEquals(array('arg1', 'arg2'), $value['e']);
    }

    /**
     * Test that check_argument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissing()
    {
        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '-b'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('b' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Missing argument for -{parameter}', array('parameter' => 'b' ));

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b:'));

        $this->assertFalse($value);
    }

    /**
     * Test that check_argument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissingWithAnotherParameterAfter()
    {
        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '-b', '-c'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('b' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Missing argument for -{parameter}', array('parameter' => 'b' ));

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b:'));

        $this->assertFalse($value);
    }

}

?>
