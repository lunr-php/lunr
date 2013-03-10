<?php

/**
 * This file contains the L10nTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10n;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the L10n class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\L10n
 */
class L10nTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the L10n class.
     * @var L10n
     */
    protected $class;

    /**
     * Reflection Instance of the L10n class.
     */
    protected $reflection;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of a FilesystemAccessObject class.
     * @var FilesystemAccessObjectInterface
     */
    protected $fao;

    /**
     * Array of supported languages.
     * @var array
     */
    protected $languages;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');
        $this->fao    = $this->getMock('Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface');

        $this->class = new L10n($this->logger, $this->fao);

        $this->reflection = new ReflectionClass('Lunr\L10n\L10n');

        $this->languages = array('de_DE', 'en_US', 'nl_NL');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->fao);
        unset($this->class);
        unset($this->reflection);
        unset($this->languages);
    }

    /**
     * Test that $languages is initially empty.
     */
    public function testLanguagesEmpty()
    {
        $properties = $this->reflection->getStaticProperties();
        $languages  = $properties['languages'];
        $this->assertEmpty($languages);
    }

    /**
     * Test that the Logger class is passed correctly.
     */
    public function testLoggerIsPassedCorrectly()
    {
        $property = $this->reflection->getProperty('logger');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInstanceOf('Psr\Log\LoggerInterface', $value);
        $this->assertSame($this->logger, $value);
    }

    /**
     * Test that the FilesystemAccessObject class is passed correctly.
     */
    public function testFAOIsPassedCorrectly()
    {
        $property = $this->reflection->getProperty('fao');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInstanceOf('Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface', $value);
        $this->assertSame($this->fao, $value);
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testDefaultLanguageSetCorrectly()
    {
        $property = $this->reflection->getProperty('default_language');
        $property->setAccessible(TRUE);

        $this->assertEquals('en_US', $property->getValue($this->class));
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testLocaleLocationSetCorrectly()
    {
        $property = $this->reflection->getProperty('locales_location');
        $property->setAccessible(TRUE);

        // /usr/bin/l10n by default
        $default_location = dirname($_SERVER['PHP_SELF']) . '/l10n';

        $this->assertEquals($default_location, $property->getValue($this->class));
    }

    /**
     * Test initial call to get_supported_languages().
     *
     * @depends testLanguagesEmpty
     * @covers  Lunr\L10n\L10n::get_supported_languages
     */
    public function testInitialGetSupportedLanguages()
    {
        $this->fao->expects($this->once())
                  ->method('get_list_of_directories')
                  ->with(dirname($_SERVER['PHP_SELF']) . '/l10n')
                  ->will($this->returnValue(array('de_DE', 'nl_NL')));

        $languages = $this->class->get_supported_languages();
        sort($languages);
        $this->assertEquals($this->languages, $languages);
    }

    /**
     * Test that get_supported_languages() populated $languages.
     *
     * @depends testInitialGetSupportedLanguages
     */
    public function testLanguagesPopulated()
    {
        $properties = $this->reflection->getStaticProperties();
        $languages  = $properties['languages'];
        sort($languages);
        $this->assertEquals($this->languages, $languages);
    }

    /**
     * Test get_supported_languages() when it was already executed before.
     *
     * @depends testLanguagesPopulated
     * @covers  Lunr\L10n\L10n::get_supported_languages
     */
    public function testCachedGetSupportedLanguages()
    {
        $this->fao->expects($this->never())
                  ->method('get_list_of_directories');

        $languages = $this->class->get_supported_languages();
        sort($languages);
        $this->assertEquals($this->languages, $languages);
    }

    /**
     * Test iso_to_posix() with supported languages.
     *
     * @param String $iso   ISO language definition
     * @param String $posix POSIX language definition
     *
     * @depends      testCachedGetSupportedLanguages
     * @dataProvider supportedLanguagesProvider
     * @covers       Lunr\L10n\L10n::iso_to_posix
     */
    public function testIsoToPosixForSupportedLanguages($iso, $posix)
    {
        $this->assertEquals($posix, $this->class->iso_to_posix($iso));
    }

    /**
     * Test iso_to_posix() with unsupported languages.
     *
     * @param String $iso ISO language definition
     *
     * @depends      testCachedGetSupportedLanguages
     * @dataProvider unsupportedLanguagesProvider
     * @covers       Lunr\L10n\L10n::iso_to_posix
     */
    public function testIsoToPosixForUnsupportedLanguages($iso)
    {
        $this->assertEquals('en_US', $this->class->iso_to_posix($iso));
    }

    /**
     * Unit Test Data Provider for supported languages.
     *
     * @return array $languages Array of supported languages
     */
    public function supportedLanguagesProvider()
    {
        $languages   = array();
        $languages[] = array('en', 'en_US');
        $languages[] = array('nl', 'nl_NL');

        return $languages;
    }

    /**
     * Unit Test Data Provider for unsupported languages.
     *
     * @return array $languages Array of unsupported languages
     */
    public function unsupportedLanguagesProvider()
    {
        $languages   = array();
        $languages[] = array('fr', 'fr_FR');

        return $languages;
    }

}

?>
