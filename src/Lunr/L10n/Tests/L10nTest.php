<?php

/**
 * This file contains the L10nTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10n;
use Lunr\Halo\LunrBaseTest;
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
abstract class L10nTest extends LunrBaseTest
{

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

        $this->languages = [ 'de_DE', 'en_US', 'nl_NL' ];
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
     * Unit Test Data Provider for supported languages.
     *
     * @return array $languages Array of supported languages
     */
    public function supportedLanguagesProvider()
    {
        $languages   = [];
        $languages[] = [ 'en', 'en_US' ];
        $languages[] = [ 'nl', 'nl_NL' ];

        return $languages;
    }

    /**
     * Unit Test Data Provider for unsupported languages.
     *
     * @return array $languages Array of unsupported languages
     */
    public function unsupportedLanguagesProvider()
    {
        $languages   = [];
        $languages[] = [ 'fr', 'fr_FR' ];

        return $languages;
    }

}

?>
