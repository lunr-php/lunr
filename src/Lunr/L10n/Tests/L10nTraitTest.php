<?php

/**
 * This file contains the L10nTraitTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10nTrait;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the L10n class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\L10nTrait
 */
class L10nTraitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the L1onTrait trait.
     * @var L10nTrait
     */
    protected $class;

    /**
     * Reflection instance of the L10nTrait trait.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * The language used for testing.
     * @var String
     */
    const LANGUAGE = 'de_DE';

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->class      = $this->getObjectForTrait('Lunr\L10n\L10nTrait');
        $this->reflection = new ReflectionClass($this->class);
        $this->logger     = $this->getMock('Psr\Log\LoggerInterface');

        $property = $this->reflection->getProperty('logger');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, $this->logger);
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->logger);
    }

    /**
     * Test that setting a valid default language stores it in the object.
     *
     * @covers Lunr\L10n\L10nTrait::set_default_language
     */
    public function testSetValidDefaultLanguage()
    {
        $property = $this->reflection->getProperty('default_language');
        $property->setAccessible(TRUE);

        $this->class->set_default_language(self::LANGUAGE);

        $this->assertEquals(self::LANGUAGE, $property->getValue($this->class));
    }

    /**
     * Test that setting an invalid default language doesn't store it in the object.
     *
     * @covers Lunr\L10n\L10nTrait::set_default_language
     */
    public function testSetInvalidDefaultLanguage()
    {
        $property = $this->reflection->getProperty('default_language');
        $property->setAccessible(TRUE);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Invalid default language: Whatever');

        $this->class->set_default_language('Whatever');

        $this->assertNull($property->getValue($this->class));
    }

    /**
     * Test that setting a valid default language doesn't alter the currently set locale.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\L10n\L10nTrait::set_default_language
     */
    public function testSetValidDefaultLanguageDoesNotAlterCurrentLocale()
    {
        $current = setlocale(LC_MESSAGES, 0);

        $this->class->set_default_language(self::LANGUAGE);

        $this->assertEquals($current, setlocale(LC_MESSAGES, 0));
    }

    /**
     * Test that setting an invalid default language doesn't alter the currently set locale.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\L10n\L10nTrait::set_default_language
     */
    public function testSetInvalidDefaultLanguageDoesNotAlterCurrentLocale()
    {
        $current = setlocale(LC_MESSAGES, 0);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Invalid default language: Whatever');

        $this->class->set_default_language('Whatever');

        $this->assertEquals($current, setlocale(LC_MESSAGES, 0));
    }

    /**
     * Test that setting a valid locales location stores it in the object.
     *
     * @covers Lunr\L10n\L10nTrait::set_locales_location
     */
    public function testSetValidLocalesLocation()
    {
        $property = $this->reflection->getProperty('locales_location');
        $property->setAccessible(TRUE);

        $location = dirname(__FILE__) . '/../../../../tests/statics/l10n';

        $this->class->set_locales_location($location);

        $this->assertEquals($location, $property->getValue($this->class));
    }

    /**
     * Test that setting an invalid locales location doesn't store it in the object.
     *
     * @covers Lunr\L10n\L10nTrait::set_locales_location
     */
    public function testSetInvalidLocalesLocation()
    {
        $property = $this->reflection->getProperty('locales_location');
        $property->setAccessible(TRUE);

        $location = dirname(__FILE__) . '/../../../tests/statics/l10n';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Invalid locales location: ' . $location);

        $this->class->set_locales_location($location);

        $this->assertNull($property->getValue($this->class));
    }

}

?>
