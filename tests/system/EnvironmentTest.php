<?php

/**
 * This file contains the EnvironmentTest class.
 *
 * @package    Core\Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * This class tests for a proper test environment.
 *
 * @covers Lunr\EnvironmentTest
 */
class EnvironmentTest extends TestCase
{

    /**
     * Test whether we have language files available.
     */
    public function testL10nFiles()
    {
        $file = TEST_STATICS . '/l10n/de_DE/LC_MESSAGES/Lunr.mo';
        if (!file_exists($file))
        {
            $this->markTestSkipped('.mo file required, please run ant l10n to generate it');
            return;
        }

        $this->assertTrue(file_exists($file));
    }

}

?>
