<?php

/**
 * This file contains the abstract definition for the
 * Localization Provider.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * Gettext Localization Provider class
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class L10nProviderGettext extends L10nProvider
{

    /**
     * Constructor
     *
     * @param String $language POSIX locale definition
     */
    public function __construct($language)
    {
        parent::__construct();
        $this->language = $language;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {

    }

    /**
     * Initialization method for setting up the provider
     *
     * @param String $language POSIX locale definition
     *
     * @return void
     */
    protected function init($language)
    {
        global $config;
        setlocale(LC_MESSAGES, $language);
        bindtextdomain($config['l10n']['domain'], $config['l10n']['locales']);
        textdomain($config['l10n']['domain']);
    }

    /**
     * Return a translated string
     *
     * @param String $identifier Identifier for the requested string
     * @param String $context    Context information fot the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    public function lang($identifier, $context = "")
    {
        global $config;
        require_once("class.output.inc.php");
        $this->init($this->language);
        if ($context == "")
        {
            $output = gettext($identifier);
            return $output;
        }
        else
        {
            // Glue msgctxt and msgid together, with ASCII character 4
            // (EOT, End Of Text)
            $composed = "{$context}\004{$identifier}";
            $output = dcgettext(
                $config['l10n']['domain'],
                $composed,
                LC_MESSAGES
            );

            if ($output == $composed
                && $this->language != $config['l10n']['default_language'])
            {
                return $identifier;
            }
            else
            {
                return $output;
            }
        }
    }

    /**
     * Return a translated string, with proper singular/plural form
     *
     * @param String  $singular Identifier for the singular version of
     *                          the string
     * @param String  $plural   Identifier for the plural version of
     *                          the string
     * @param Integer $amount   The amount the translation should be based on
     * @param String  $context  Context information fot the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    public function nlang($singular, $plural, $amount, $context = "")
    {
        require_once("class.output.inc.php");
        $this->init($this->language);
        if ($context == "")
        {
            $output = ngettext($singular, $plural, $amount);
            return $output;
        }
        else
        {
            global $config;
            // Glue msgctxt and msgid together, with ASCII character 4
            // (EOT, End Of Text)
            $composed = "{$context}\004{$singular}";
            $output = dcngettext(
                $config['l10n']['domain'],
                $composed,
                $plural,
                $amount,
                LC_MESSAGES
            );

            if ((($output == $composed) || ($output == $plural))
                && $this->language != $config['l10n']['default_language'])
            {
                return ($amount == 1 ? $singular : $plural);
            }
            else
            {
                return $output;
            }
        }
    }

}

?>
