<?php

/**
 * This file contains the L10nProviderTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\L10n;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the abstract L10nProvider class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\L10n\L10nProvider
 */
class L10nProviderTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the L10nProvider class.
     * @var L10nProvider
     */
    private $provider;

    /**
     * The language used for testing.
     * @var String
     */
    const LANGUAGE = "de";

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->provider = $this->getMockBuilder('Lunr\Libraries\L10n\L10nProvider')
                               ->setConstructorArgs(array(self::LANGUAGE))
                               ->getMockForAbstractClass();

        $this->provider_reflection = new ReflectionClass('Lunr\Libraries\L10n\L10nProvider');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->provider);
        unset($this->provider_reflection);
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function test_language_set_correctly()
    {
        $property = $this->provider_reflection->getProperty('language');
        $property->setAccessible(TRUE);

        $this->assertEquals(self::LANGUAGE, $property->getValue($this->provider));
    }

    /**
     * Test that get_language() returns the set language.
     *
     * @covers Lunr\Libraries\L10n\L10nProvider::get_language
     */
    public function test_get_language_returns_language()
    {
        $this->assertEquals(self::LANGUAGE, $this->provider->get_language());
    }

}

?>
