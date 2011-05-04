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
 */

/**
 * PHP (array) Localization Provider class
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class L10nProviderPHP extends L10nProvider
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

    }

    /**
     * Attribute that stores the language array
     * @var array
     */
    private $lang_array;

    /**
     * Initialization method for setting up the provider.
     *
     * @param String $language POSIX locale definition
     *
     * @return void
     */
    protected function init($language)
    {
        global $config;
        $this->language = $language;

        if ($this->language != $config['l10n']['default_language'])
        {
            include_once($config['l10n']['php_lang_file']);
            $this->lang_array = $lang;
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
    public function lang($identifier, $context = "")
    {
        global $config;

        //Check if it's necessary to translate the identifier
        if ($this->language != $config['l10n']['default_language'])
        {

                if ($context == "")
                {

                    //Check if the identifier is contained in the language array
                    if (array_key_exists($identifier, $this->lang_array))
                    {
                       return $this->lang_array[$identifier];
                    }

                    return $identifier;

                }

                else //Check if the identifier is contained in the language array and if the context string is contained in the second dimension of the array
                {
                   if (array_key_exists($identifier, $this->lang_array) && array_key_exists($context, $this->lang_array[$identifier]))
                   {
                        return $this->lang_array[$identifier][$context];
                   }

                   return $identifier;
                }

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
    public function nlang($singular, $plural, $amount, $context = "")
    {


            if($context =="")
            {
                        //Check if singular and plural identifiers are contained in the language array
                        if (array_key_exists($singular, $this->lang_array) && array_key_exists($plural, $this->lang_array) )
                        {
                            return ($amount == 1 ? $this->lang_array[$singular] : $this->lang_array[$plural]);
                        }

                        return $singular;
            }
            else
            {

                if (
                    //Check if singular and plural identifiers are contained in the language array
                    (array_key_exists($singular, $this->lang_array) && array_key_exists($plural, $this->lang_array)) &&

                    //and if context is contained in singular and plural sub arrays
                    (array_key_exists($context, $this->lang_array[$singular]) && array_key_exists($context, $this->lang_array[$plural]))
                   )
                {
                    return ($amount == 1 ? $this->lang_array[$singular][$context] : $this->lang_array[$plural][$context]);
                }
                else
                {
                    return $singular;
                }


            }

        //return ($amount == 1 ? $singular : $plural);
    }

}

?>
