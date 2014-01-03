<?php

/**
 * This file contains the EinvironmentTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class tests for a proper test environment.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\EnvironmentTest
 */
class EnvironmentTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test whether we have language files available.
     */
    public function testL10nFiles()
    {
        $file = TEST_STATICS . '/l10n/de_DE/LC_MESSAGES/Lunr.mo';
        $this->assertTrue(file_exists($file));
    }

}

?>
