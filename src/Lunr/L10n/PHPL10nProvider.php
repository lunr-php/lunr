<?php

/**
 * This file contains the abstract definition for the
 * PHP array Localization Provider.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Jose Viso <jose@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n;

/**
 * PHP (array) Localization Provider class
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Jose Viso <jose@m2mobi.com>
 */
class PHPL10nProvider extends L10nProvider
{

    /**
     * Attribute that stores the language array
     * @var array
     */
    private $lang_array;

    /**
     * Whether the lang_array was initialized already or not.
     * @var Boolean
     */
    private $initialized;

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

        $this->initialized = FALSE;
        $this->lang_array  = array();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
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
        if ($this->initialized === TRUE)
        {
            return;
        }

        if ($language != $this->default_language)
        {
            $lang     = array();
            $langpath = $this->locales_location . '/' . $language . '/';
            include $langpath . $this->domain . '.php';
            $this->lang_array =& $lang;
        }

        $this->initialized = TRUE;
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
        if ($this->language == $this->default_language)
        {
            return $identifier;
        }

        $this->init($this->language);

        //Check if the identifier is not contained in the language array
        if (!array_key_exists($identifier, $this->lang_array))
        {
            return $identifier;
        }

        if ($context == '')
        {
            //Check if the key have context asociated in the array
            if (is_array($this->lang_array[$identifier]))
            {
                foreach($this->lang_array[$identifier] as $value)
                {
                    if (is_array($value) && isset($value[0]))
                    {
                        return $value[0];
                    }
                }

                return $identifier;
            }
            else
            {
                return $this->lang_array[$identifier];
            }
        }

        if (!is_array($this->lang_array[$identifier]) || !array_key_exists($context, $this->lang_array[$identifier]))
        {
            return $identifier;
        }
        else
        {
            return $this->lang_array[$identifier][$context];
        }
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
        if ($this->language == $this->default_language)
        {
            return ($amount == 1 ? $singular : $plural);
        }

        $this->init($this->language);

        //Check if there is a translation available
        if (!array_key_exists($singular, $this->lang_array))
        {
            return ($amount == 1 ? $singular : $plural);
        }

        // Check if the base string actually has plural forms available
        if (!is_array($this->lang_array[$singular]))
        {
            return $this->lang_array[$singular];
        }

        // Check if we have a simple translation with the given context
        if (($context != '')
            && !array_key_exists($plural, $this->lang_array[$singular])
            && array_key_exists($context, $this->lang_array[$singular])
            && !is_array($this->lang_array[$singular][$context]))
        {
            return $this->lang_array[$singular][$context];
        }

        // Check if we have plural forms available
        if (!array_key_exists($plural, $this->lang_array[$singular]))
        {
            return ($amount == 1 ? $singular : $plural);
        }

        if ($context == '')
        {
            if (!is_array($this->lang_array[$singular][$plural])
                || !isset($this->lang_array[$singular][$plural][0])
                || !isset($this->lang_array[$singular][$plural][1]))
            {
                return ($amount == 1 ? $singular : $plural);
            }

            if ($amount == 1)
            {
                return $this->lang_array[$singular][$plural][0];
            }
            else
            {
                return $this->lang_array[$singular][$plural][1];
            }
        }

        // Check whether we have the given context available
        if (!is_array($this->lang_array[$singular][$plural])
            || !isset($this->lang_array[$singular][$plural][$context])
            || !is_array($this->lang_array[$singular][$plural][$context]))
        {
            return ($amount == 1 ? $singular : $plural);
        }

        if ($amount == 1)
        {
            return $this->lang_array[$singular][$plural][$context][0];
        }
        else
        {
            return $this->lang_array[$singular][$plural][$context][1];
        }
    }

}

?>
