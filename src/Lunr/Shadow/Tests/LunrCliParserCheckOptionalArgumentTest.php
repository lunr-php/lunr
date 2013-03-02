<?php

/**
 * This file contains the LunrCliParserCheckOptionalArgumentTest class.
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
class LunrCliParserCheckOptionalArgumentTest extends LunrCliParserTest
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
        $args->setValue($this->class, array('test.php', '-c', 'arg'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('c' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $value = $method->invokeArgs($this->class, array('c', 1, 0, 'c;'));

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
        $args->setValue($this->class, array('test.php', '-f', 'arg1', 'arg2'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('f' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $value = $method->invokeArgs($this->class, array('f', 1, 0, 'f;;'));

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
        $args->setValue($this->class, array('test.php', '-c', 'arg'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('c' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->class, array('c', 1, 0, 'c;'));

        $value = $ast->getValue($this->class);

        $this->assertCount(1, $value['c']);
        $this->assertEquals(array('arg'), $value['c']);
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
        $args->setValue($this->class, array('test.php', '-f', 'arg1', 'arg2'));

        $ast = $this->reflection->getProperty('ast');
        $ast->setAccessible(TRUE);
        $ast->setValue($this->class, array('f' => array()));

        $method = $this->reflection->getMethod('check_argument');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->class, array('f', 1, 0, 'f;;'));

        $value = $ast->getValue($this->class);

        $this->assertCount(2, $value['f']);
        $this->assertEquals(array('arg1', 'arg2'), $value['f']);
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

        $this->logger->expects($this->never())
                     ->method('error');

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b;'));

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

        $this->logger->expects($this->never())
                     ->method('error');

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b;'));

        $this->assertFalse($value);
    }

}

?>
