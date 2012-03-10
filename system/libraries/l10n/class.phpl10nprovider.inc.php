<?php

/**
 * This file contains the abstract definition for the
 * PHP array Localization Provider.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Jose Viso <jose@m2mobi.com>
 */

namespace Lunr\Libraries\L10n;

/**
 * PHP (array) Localization Provider class
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Jose Viso <jose@m2mobi.com>
 */
class PHPL10nProvider extends L10nProvider
{

    /**
     * Reference to the Configuration class.
     * @var Configuration
     */
    private $configuration;

    /**
     * Reference to the Logger class.
     * @var Logger
     */
    private $logger;

    /**
     * Attribute that stores the language array
     * @var array
     */
    private $lang_array;

    /**
     * Constructor.
     *
     * @param String        $language       POSIX locale definition
     * @param Configuration &$configuration Reference to the Configuration class
     * @param Logger        &$logger        Reference to the Logger class
     */
    public function __construct($language, &$configuration, &$logger)
    {
        parent::__construct($language);

        $this->configuration =& $configuration;
        $this->logger =& $logger;

        $this->init($language);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->configuration = NULL;
        $this->logger = NULL;
        unset($this->lang_array);
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
        if ($language != $this->configuration['l10n']['default_language'])
        {
            $lang = array();
            include_once $this->configuration['l10n']['locales']. '/' . $language . '/' . $this->configuration['l10n']['domain'] . '.php';
            $this->lang_array =& $lang;
        }
        else
        {
            $this->lang_array = array();
        }
    }

    /**
     * Return a translated string.
     *
     * @param String $identifier Identifier for the requested string
     * @param String $context    Context information for the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    public function lang($identifier, $context = '')
    {
        //Check if it's necessary to translate the identifier
        if ($this->language == $this->configuration['l10n']['default_language'])
        {
            return $identifier;
        }

        //Check if the identifier is not contained in the language array
        if (!array_key_exists($identifier, $this->lang_array))
        {
            $this->logger->log_error('Identifier not contained in the language array: ' . $identifier);
        }
        elseif ($context == '')
        {
            //Check if the key have context asociated in the array
            if (is_array($this->lang_array[$identifier]))
            {
                $this->logger->log_error('Identifier with context: ' . $identifier);
            }
            else
            {
                return $this->lang_array[$identifier];
            }
        }
        elseif (!array_key_exists($context, $this->lang_array[$identifier]))
        {
            $this->logger->log_error('Identifier not included in the language array: ' . $identifier);
        }
        else
        {
            return $this->lang_array[$identifier][$context];
        }

        return $identifier;
    }

    /**
     * Return a translated string, with proper singular/plural form.
     *
     * @param String  $singular Identifier for the singular version of
     *                          the string
     * @param String  $plural   Identifier for the plural version of the string
     * @param Integer $amount   The amount the translation should be based on
     * @param String  $context  Context information fot the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    public function nlang($singular, $plural, $amount, $context = '')
    {
        //Check if it's necessary to translate
        if ($this->language == $this->configuration['l10n']['default_language'])
        {
            return ($amount == 1 ? $singular : $plural);
        }

        //Check if the singular key is not in the language array
        if (!array_key_exists($singular, $this->lang_array))
        {
            $this->logger->log_error('Identifier for the singular key not included in the language array: ' . $singular);
        }
        elseif (!array_key_exists($plural, $this->lang_array))
        {
            $this->logger->log_error('Identifier for the plural key not included in the language array: ' . $plural);
        }
        elseif ($context == '')
        {
            if (is_array($this->lang_array[$singular]))
            {
                $this->logger->log_error('Identifier with context: ' . $singular);
            }
            elseif (is_array($this->lang_array[$plural]))
            {
                $this->logger->log_error('Identifier with context: ' . $plural);
            }
            else
            {
                return ($amount == 1 ? $this->lang_array[$singular] : $this->lang_array[$plural]);
            }
        }
        elseif(!is_array($this->lang_array[$singular]) || !array_key_exists($context, $this->lang_array[$singular]))
        {
            $this->logger->log_error('Context not included in the singular array: ' . $singular);
        }
        elseif (!is_array($this->lang_array[$plural]) || !array_key_exists($context, $this->lang_array[$plural]) )
        {
            $this->logger->log_error('Context not included in the plural array: ' . $plural);
        }
        else // No exceptions
        {
            return ($amount == 1 ? $this->lang_array[$singular][$context] : $this->lang_array[$plural][$context]);
        }
    }

}

?>
