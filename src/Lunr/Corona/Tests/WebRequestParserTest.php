<?php

/**
 * This file contains the WebRequestParserTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\WebRequestParser;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WebRequestParser class.
 *
 * @covers     Lunr\Corona\WebRequestParser
 */
abstract class WebRequestParserTest extends LunrBaseTest
{

    /**
     * Mock of the Configuration class.
     * @var \Lunr\Core\Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the Header class
     * @var \http\Header
     */
    protected $header;

    /**
     * Shared TestCase Constructor code.
     *
     * @return void
     */
    public function setUp()
    {
        $this->configuration = $this->getMock('Lunr\Core\Configuration');
        $this->header        = $this->getMock('http\Header');

        $this->class      = new WebRequestParser($this->configuration, $this->header);
        $this->reflection = new ReflectionClass('Lunr\Corona\WebRequestParser');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->configuration);
        unset($this->header);
    }

    /**
     * Unit Test Data Provider for invalid super global values.
     *
     * @return array $cookie Set of invalid super global values
     */
    public function invalidSuperglobalValueProvider()
    {
        $values   = [];
        $values[] = [ [], FALSE];
        $values[] = [ 0, FALSE];
        $values[] = [ 'String', FALSE];
        $values[] = [ TRUE, FALSE];
        $values[] = [ NULL, FALSE ];
        $values[] = [ [], TRUE];
        $values[] = [ 0, TRUE];
        $values[] = [ 'String', TRUE];
        $values[] = [ TRUE, TRUE];
        $values[] = [ NULL, TRUE ];

        return $values;
    }

    /**
     * Unit Test Data Provider for Accept header content type(s).
     *
     * @return array $value Array of content type(s)
     */
    public function contentTypeProvider()
    {
        $value   = [];
        $value[] = [ 'text/html' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header language(s).
     *
     * @return array $value Array of language(s)
     */
    public function acceptLanguageProvider()
    {
        $value   = [];
        $value[] = [ 'en-US' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header charset(s).
     *
     * @return array $value Array of charset(s)
     */
    public function acceptCharsetProvider()
    {
        $value   = [];
        $value[] = [ 'utf-8' ];

        return $value;
    }

}

?>
