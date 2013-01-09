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
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\PHPL10nProvider;
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
 * @covers     Lunr\L10n\PHPL10nProvider
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
     * Mock Object for a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * The language used for testing.
     * @var String
     */
    const LANGUAGE = 'de_DE';

    /**
     * The domain used for testing.
     * @var String
     */
    const DOMAIN = 'Lunr';

    /**
     * TestCase Constructor.
     *
     * Setup a plain (empty) PHPL10nProvider
     *
     * @return void
     */
    public function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->provider_reflection = new ReflectionClass('Lunr\L10n\PHPL10nProvider');

        $this->provider = new PHPL10nProvider(self::LANGUAGE, self::DOMAIN, $this->logger);
        $this->provider->set_locales_location(dirname(__FILE__) . '/../../../../tests/statics/l10n');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->provider);
        unset($this->provider_reflection);
        unset($this->logger);
    }

}

?>
