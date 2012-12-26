<?php

/**
 * This file contains the L10nProviderTest class.
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

use Lunr\L10n\L10nProvider;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the abstract L10nProvider class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\L10nProvider
 */
abstract class L10nProviderTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the L10nProvider class.
     * @var L10nProvider
     */
    protected $provider;

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

        $this->provider = $this->getMockBuilder('Lunr\L10n\L10nProvider')
                               ->setConstructorArgs(array(self::LANGUAGE, self::DOMAIN, $this->logger))
                               ->getMockForAbstractClass();

        $this->provider_reflection = new ReflectionClass('Lunr\L10n\L10nProvider');
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
