<?php

/**
 * This file contains the L10nTraitBaseTest class.
 *
 * @package    Lunr\L10n
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

/**
 * This class contains test methods for the L10n class.
 *
 * @covers Lunr\L10n\L10nTrait
 */
class L10nTraitBaseTest extends L10nTraitTest
{

    /**
     * Test that setting a valid default language stores it in the object.
     *
     * @covers Lunr\L10n\L10nTrait::set_default_language
     */
    public function testSetValidDefaultLanguage(): void
    {
        $this->class->set_default_language(self::LANGUAGE);

        $this->assertPropertyEquals('default_language', self::LANGUAGE);
    }

    /**
     * Test that setting an invalid default language doesn't store it in the object.
     *
     * @covers Lunr\L10n\L10nTrait::set_default_language
     */
    public function testSetInvalidDefaultLanguage(): void
    {
        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Invalid default language: Whatever');

        $this->class->set_default_language('Whatever');

        $this->assertNull($this->get_reflection_property_value('default_language'));
    }

    /**
     * Test that setting a valid default language doesn't alter the currently set locale.
     *
     * @covers Lunr\L10n\L10nTrait::set_default_language
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
     * @covers Lunr\L10n\L10nTrait::set_default_language
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
     * @covers Lunr\L10n\L10nTrait::set_locales_location
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
     * @covers Lunr\L10n\L10nTrait::set_locales_location
     */
    public function testSetInvalidLocalesLocation(): void
    {
        $location = TEST_STATICS . '/../l10n';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Invalid locales location: ' . $location);

        $this->class->set_locales_location($location);

        $this->assertNull($this->get_reflection_property_value('locales_location'));
    }

}

?>
