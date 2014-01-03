<?php

/**
 * This file contains the abstract definition for the
 * Gettext Localization Provider.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n;

/**
 * Gettext Localization Provider class
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class GettextL10nProvider extends L10nProvider
{

    /**
     * Define gettext msgid size limit
     * @var Integer
     */
    const GETTEXT_MAX_MSGID_LENGTH = 4096;

    /**
     * Constructor.
     *
     * @param String          $language POSIX locale definition
     * @param String          $domain   Localization domain
     * @param LoggerInterface $logger   Shared instance of a logger class
     */
    public function __construct($language, $domain, $logger)
    {
        parent::__construct($language, $domain, $logger);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Initialization method for setting up the provider.
     *
     * @param String $language POSIX locale definition
     *
     * @return void
     */
    protected function init($language)
    {
        setlocale(LC_MESSAGES, $language);
        bindtextdomain($this->domain, $this->locales_location);
        textdomain($this->domain);
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
        if (strlen($identifier) + strlen($context) + 1 > self::GETTEXT_MAX_MSGID_LENGTH)
        {
            $this->logger->warning('Identifier too long: ' . $identifier);

            return $identifier;
        }

        $this->init($this->language);

        if ($context == '')
        {
            return gettext($identifier);
        }

        // Glue msgctxt and msgid together, with ASCII character 4
        // (EOT, End Of Text)
        $composed = "{$context}\004{$identifier}";
        $output   = dcgettext($this->domain, $composed, LC_MESSAGES);

        if (($output == $composed) && ($this->language != $this->default_language))
        {
            return $identifier;
        }
        else
        {
            return $output;
        }
    }

    /**
     * Return a translated string, with proper singular/plural form.
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
    public function nlang($singular, $plural, $amount, $context = '')
    {
        if (strlen($singular) + strlen($context) + 1 > self::GETTEXT_MAX_MSGID_LENGTH)
        {
            $this->logger->warning('Identifier too long: ' . $singular);

            return $singular;
        }

        $this->init($this->language);

        if ($context == '')
        {
            return ngettext($singular, $plural, $amount);
        }

        // Glue msgctxt and msgid together, with ASCII character 4
        // (EOT, End Of Text)
        $composed = "{$context}\004{$singular}";
        $output   = dcngettext($this->domain, $composed, $plural, $amount, LC_MESSAGES);

        if ((($output == $composed) || ($output == $plural))
            && ($this->language != $this->default_language))
        {
            return ($amount == 1 ? $singular : $plural);
        }
        else
        {
            return $output;
        }
    }

}

?>
