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
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
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
     */
    public function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->provider = new GettextL10nProvider(self::LANGUAGE, self::DOMAIN, $this->logger);
        $this->provider->set_default_language('nl_NL');
        $this->provider->set_locales_location(TEST_STATICS . '/l10n');

        $this->provider_reflection = new ReflectionClass('Lunr\L10n\GettextL10nProvider');
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
