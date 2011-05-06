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
     * Attribute that stores the language array
     * @var array
     */
    private $lang_array;

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
            include_once ($config['l10n']['locales']. "/" . $this->language . "_lang.php");

            $this->lang_array = &$lang;
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

            //Check if the identifier is not contained in the language array
            if (!array_key_exists($identifier, $this->lang_array))
            {
                Output::error("Identifier not contained in the language array: " . $identifier);
            }

            elseif ($context == "")
            {
                    //Check if the key have context asociated in the array
                    if (is_array($this->lang_array[$identifier]))
                    {
                        Output::error("Identifier with context: " . $identifier);

                    }
                    else // No exceptions
                    {
                        return $this->lang_array[$identifier];
                    }

            }

                else //If there is context information
                {

                  //Check if the context is not contained in the language array
                  if (!array_key_exists($context, $this->lang_array[$identifier]))
                  {
                      Output::error("Identifier not included in the language array: " . $identifier);

                  }
                  else // No exceptions
                  {
                      return $this->lang_array[$identifier][$context];
                  }

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

     //Check if the singular key is not in the language array
     if(!array_key_exists($singular, $this->lang_array))
     {
        Output::error("Identifier for the singular key not included in the language array: " . $singular);
     }

     //Check if the plural key is not in the language array
     elseif ( !array_key_exists($plural, $this->lang_array))
     {
        Output::error("Identifier for the plural key not included in the language array: " . $plural);
     }
     else
     {

        if($context =="")
        {
            if (is_array($this->lang_array[$singular]))
            {
                Output::error("Identifier with context: " . $singular);
            }
            elseif (is_array($this->lang_array[$plural]))
            {
                 Output::error("Identifier with context: " . $plural);
            }
            else // No exceptions
            {
                return ($amount == 1 ? $this->lang_array[$singular] : $this->lang_array[$plural]);
            }
        }
        else
        {

            if(!is_array($this->lang_array[$singular]) || !array_key_exists($context, $this->lang_array[$singular]))
            {

                Output::error("Context not included in the singular array: " . $singular);
            }
            elseif (!is_array($this->lang_array[$plural]) || !array_key_exists($context, $this->lang_array[$plural]) )
            {
                Output::error("Context not included in the plural array: " . $plural);

            }

            else // No exceptions
            {
                return ($amount == 1 ? $this->lang_array[$singular][$context] : $this->lang_array[$plural][$context]);
            }

        }

     }

    }


}

?>
