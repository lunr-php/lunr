<?php

/**
 * This file contains the GettextL10nProviderTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\GettextL10nProvider;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GettextL10nProvider class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\GettextL10nProvider
 */
abstract class GettextL10nProviderTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the GettextL10nProvider class.
     * @var GettextL10nProvider
     */
    protected $provider;

    /**
     * Reflection instance of the GettextL10nProvider class.
     * @var ReflectionClass
     */
    protected $provider_reflection;

    /**
     * Mock Object for the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * The language used for testing.
     * @var String
     */
    const LANGUAGE = 'de_DE';

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('domain', 'Lunr'),
            array('locales', dirname(__FILE__) . '/../../../../tests/statics/l10n'),
            array('default_language', 'nl_NL'),
        );

        $sub_configuration->expects($this->any())
                          ->method('offsetGet')
                          ->will($this->returnValueMap($map));

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('l10n', $sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $logger = $this->getMockBuilder('Lunr\Core\Logger')
                       ->disableOriginalConstructor()
                       ->getMock();

        $this->provider = new GettextL10nProvider(self::LANGUAGE, $this->configuration, $logger);

        $this->provider_reflection = new ReflectionClass('Lunr\L10n\GettextL10nProvider');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->provider);
        unset($this->provider_reflection);
        unset($this->configuration);
    }

}

?>
