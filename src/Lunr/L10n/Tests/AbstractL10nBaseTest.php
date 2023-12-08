<?php

/**
 * This file contains the AbstractL10nBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;
use Throwable;

/**
 * This class contains test methods for the L10n class.
 *
 * @covers Lunr\L10n\AbstractL10n
 */
class AbstractL10nBaseTest extends AbstractL10nTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testDefaultLanguageSetCorrectly(): void
    {
        $this->assertPropertyEquals('default_language', 'en_US');
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testLocaleLocationSetCorrectly(): void
    {
        $this->assertPropertyEquals('locales_location', TEST_STATICS . '/l10n/');
    }

    /**
     * Test that setting a valid default language stores it in the object.
     *
     * @covers Lunr\L10n\AbstractL10n::set_default_language
     */
    public function testSetValidDefaultLanguage(): void
    {
        $this->class->set_default_language(self::LANGUAGE);

        $this->assertPropertyEquals('default_language', self::LANGUAGE);
    }

    /**
     * Test that setting an invalid default language doesn't store it in the object.
     *
     * @covers Lunr\L10n\AbstractL10n::set_default_language
     */
    public function testSetInvalidDefaultLanguage(): void
    {
        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Invalid default language: Whatever');

        $this->class->set_default_language('Whatever');

        $this->assertEquals('en_US', $this->get_reflection_property_value('default_language'));
    }

    /**
     * Test that setting a valid default language doesn't alter the currently set locale.
     *
     * @covers Lunr\L10n\AbstractL10n::set_default_language
     */
    public function testSetValidDefaultLanguageDoesNotAlterCurrentLocale(): void
    {
        $current = setlocale(LC_MESSAGES, 0);

        $this->class->set_default_language(self::LANGUAGE);

        $this->assertEquals($current, setlocale(LC_MESSAGES, 0));
    }

    /**
     * Test that setting an invalid default language doesn't alter the currently set locale.
     *
     * @covers Lunr\L10n\AbstractL10n::set_default_language
     */
    public function testSetInvalidDefaultLanguageDoesNotAlterCurrentLocale(): void
    {
        $current = setlocale(LC_MESSAGES, 0);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Invalid default language: Whatever');

        $this->class->set_default_language('Whatever');

        $this->assertEquals($current, setlocale(LC_MESSAGES, 0));
    }

    /**
     * Test that setting a valid locales location stores it in the object.
     *
     * @covers Lunr\L10n\AbstractL10n::set_locales_location
     */
    public function testSetValidLocalesLocation(): void
    {
        $location = TEST_STATICS . '/l10n';

        $this->class->set_locales_location($location);

        $this->assertPropertyEquals('locales_location', $location);
    }

    /**
     * Test that setting an invalid locales location doesn't store it in the object.
     *
     * @covers Lunr\L10n\AbstractL10n::set_locales_location
     */
    public function testSetInvalidLocalesLocation(): void
    {
        $location = TEST_STATICS . '/../l10n';

        $this->expectException('UnexpectedValueException');
        $this->expectExceptionMessage('Failed to open directory');

        try
        {
            $this->class->set_locales_location($location);
        }
        catch (Throwable $e)
        {
            $this->assertEquals(TEST_STATICS . '/l10n/', $this->get_reflection_property_value('locales_location'));

            throw $e;
        }
    }

}

?>
