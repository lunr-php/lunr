<?php

/**
 * This file contains the PHPL10nProviderTest class.
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

namespace Lunr\Libraries\L10n;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the PHPL10nProvider class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\L10n\PHPL10nProvider
 */
abstract class PHPL10nProviderTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the PHPL10nProvider class.
     * @var PHPL10nProvider
     */
    protected $provider;

    /**
     * Reflection instance of the PHPL10nProvider class.
     * @var ReflectionClass
     */
    protected $provider_reflection;

    /**
     * Mock Object for the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock Object for the Logger class.
     * @var Logger
     */
    protected $logger;

    /**
     * The language used for testing.
     * @var String
     */
    const LANGUAGE = 'de_DE';

    /**
     * Default language used for plain setup.
     * @var String
     */
    const DEFAULT_LANGUAGE = 'nl_NL';

    /**
     * Common setup routines for all constructors.
     *
     * @return void
     */
    public function setUpCommon()
    {
        $sub_configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $map = array(
            array('domain', 'Lunr'),
            array('locales', dirname(__FILE__) . '/../../../statics/l10n'),
            array('default_language', self::DEFAULT_LANGUAGE),
        );

        $sub_configuration->expects($this->any())
                          ->method('offsetGet')
                          ->will($this->returnValueMap($map));

        $this->configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $map = array(
            array('l10n', $sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Lunr\Libraries\Core\Logger')
                       ->disableOriginalConstructor()
                       ->getMock();

        $this->provider_reflection = new ReflectionClass('Lunr\Libraries\L10n\PHPL10nProvider');
    }

    /**
     * TestCase Constructor.
     *
     * Setup a plain (empty) PHPL10nProvider
     *
     * @return void
     */
    public function setUpPlain()
    {
        $this->setUpCommon();

        $this->provider = new PHPL10nProvider(self::DEFAULT_LANGUAGE, $this->configuration, $this->logger);
    }

    /**
     * TestCase Constructor.
     *
     * Setup a plain (empty) PHPL10nProvider
     *
     * @return void
     */
    public function setUpFull()
    {
        $this->setUpCommon();

        $this->provider = new PHPL10nProvider(self::LANGUAGE, $this->configuration, $this->logger);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->provider);
        unset($this->provider_reflection);
        unset($this->configuration);
        unset($this->logger);
    }

}

?>
