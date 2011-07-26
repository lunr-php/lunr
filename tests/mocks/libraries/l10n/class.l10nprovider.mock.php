<?php

/**
 * This file contains a L10nProvider Mock class
 * used by the Unit tests.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Mocks
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Mocks\Libraries\L10n;
use Lunr\Libraries\L10n\L10nProvider;

/**
 * Localization Provider Mock Class
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Mocks
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MockL10nProvider extends L10nProvider
{

    /**
     * Constructor.
     *
     * @param String $language POSIX locale definition
     */
    public function __construct($language)
    {
        $this->init($language);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->language);
    }

    /**
     * Initialization method for setting up the provider.
     *
     * @param String $language POSIX locale definition
     *
     * @return void
     */
    public function init($language)
    {
        $this->language = $language;
    }

    /**
     * Return a translated string.
     *
     * @param String $identifier Identifier for the requested string
     * @param String $context    Context information fot the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    public function lang($identifier, $context = '')
    {
        return FALSE;
    }

    /**
     * Return a translated string, with proper singular/plural form.
     *
     * @param String  $singular Identifier for the singular version of the
     *                          string
     * @param String  $plural   Identifier for the plural version of the string
     * @param Integer $amount   The amount the translation should be based on
     * @param String  $context  Context information fot the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    public function nlang($singular, $plural, $amount, $context = '')
    {
        return FALSE;
    }

}

?>
