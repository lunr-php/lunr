<?php

/**
 * This file contains the abstract definition for the
 * PHP array Localization Provider.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n;

use Psr\Log\LoggerInterface;

/**
 * PHP (array) Localization Provider class
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
     * @var bool
     */
    private $initialized;

    /**
     * Constructor.
     *
     * @param string          $language         POSIX locale definition
     * @param string          $domain           Localization domain
     * @param LoggerInterface $logger           Shared instance of a logger class
     * @param string          $locales_location Location of translation files
     */
    public function __construct($language, $domain, $logger, $locales_location)
    {
        parent::__construct($language, $domain, $logger, $locales_location);

        $this->initialized = FALSE;
        $this->lang_array  = [];
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
     * @param string $language POSIX locale definition
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
            $lang     = [];
            $langpath = $this->locales_location . '/' . $language . '/';
            include $langpath . $this->domain . '.php';
            $this->lang_array =& $lang;
        }

        $this->initialized = TRUE;
    }

    /**
     * Return a translated string.
     *
     * @param string $identifier Identifier for the requested string
     * @param string $context    Context information for the requested string
     *
     * @return string $string Translated string, identifier by default
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
                foreach ($this->lang_array[$identifier] as $value)
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
     * @param string $singular Identifier for the singular version of
     *                         the string
     * @param string $plural   Identifier for the plural version of the string
     * @param int    $amount   The amount the translation should be based on
     * @param string $context  Context information fot the requested string
     *
     * @return string $string Translated string, identifier by default
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
            && !is_array($this->lang_array[$singular][$context])
        )
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
                || !isset($this->lang_array[$singular][$plural][1])
            )
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
            || !is_array($this->lang_array[$singular][$plural][$context])
        )
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
