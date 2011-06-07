<?php

/**
 * This file contains an input array content verification system.
 * Additionally there are some other public verification methods.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;

/**
 * Verification class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Verification
{

    /**
     * Catch unimplemented static functions.
     *
     * @param String $method    Method name
     * @param array  $arguments Arguments to that static method
     *
     * @return Boolean $return Return value of the forwarded check,
     *                         or FALSE if check not implemented.
     */
    public static function __callStatic($method, $arguments)
    {
        if (substr($method, 0, 9) == 'is_length')
        {
            $length = substr($method, 9);
            return self::is_length($length, $arguments[0]);
        }
        elseif (substr($method, 0, 9) == 'is_ignore')
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Verify an input array against a defined ruleset.
     *
     * @param String  $identifier Identifier for the rule-checking
     * @param array   &$input     Input array
     * @param array   &$ruleset   Ruleset to check against
     * @param boolean $soft       Whether to perform soft checking or not.
     *                            Soft checking allows to have rules defined for non-existing keys
     * @param String  $file       The log file to send errors to. By default this will
     *                            be the invalid input log.
     *
     * @return Boolean $return TRUE if the input matches against the ruleset,
     *                         FALSE otherwise.
     */
    public static function verify_array_ruleset($identifier, &$input, &$ruleset, $soft = FALSE, $file = '')
    {
        if ($file == '')
        {
            global $config;
            $file  = $config['log']['invalid_input'];
            $file .= 'midschip_invalid_input.' . CLIENT_OS . '.log';
        }

        if (trim($identifier) == '')
        {
            Output::error("Can't verify input. Empty Identifier!'", $file);
            return FALSE;
        }

        if (!is_array($input) || !is_array($ruleset))
        {
            Output::error("Can't verify input. Invalid input!'", $file);
            return FALSE;
        }

        $error_prefix = "Input validation '$identifier': ";

        if ($soft !== TRUE)
        {
            // Check that input matches with the defined ruleset
            $input_elements = array_keys($input);
            $ruleset_elements = array_keys($ruleset);
            $unhandled_elements = array_diff($ruleset_elements, $input_elements);

            if ($unhandled_elements != array())
            {
                foreach ($unhandled_elements as $value)
                {
                    Output::error($error_prefix . "Ruleset for non-existing key '$value'!", $file);
                }
                return FALSE;
            }
        }

        // Go over the input array and check key by key
        foreach ($input as $key => $value)
        {
            // Check that we have a rule and it is not empty
            if (isset($ruleset[$key]) && !empty($ruleset[$key]))
            {
                // Check whether there is more than one rule for the current
                // element or not
                if (is_array($ruleset[$key]))
                {
                    foreach ($ruleset[$key] as &$rule)
                    {
                        if (call_user_func('self::is_' . $rule, $value) === FALSE)
                        {
                            Output::error($error_prefix . "Rule '$rule' failed for '$key'!", $file);
                            return FALSE;
                        }
                    }
                    unset($rule);
                }
                else
                {
                    if (call_user_func('self::is_' . $ruleset[$key], $value) === FALSE)
                    {
                        Output::error($error_prefix . "Rule '" . $ruleset[$key] . "' failed for '$key'!", $file);
                        return FALSE;
                    }
                }
            }
            else
            {
                Output::error($error_prefix . "Unhandled Array Element '$key'!", $file);
                return FALSE;
            }
        }

        //Everything looks good
        return TRUE;
    }

    /**
     * Check character length of an input.
     *
     * @param Integer $length The length to check for
     * @param mixed   &$value The input to check
     *
     * @return Boolean $return TRUE if size matches, FALSE otherwise.
     */
    public static function is_length($length, &$value)
    {
        return (strlen($value) == $length);
    }

    /**
     * Check that an input is not empty.
     *
     * Note that 0 and "0" are also considered empty.
     *
     * @param mixed $value The input to check
     *
     * @return Boolean $return TRUE if not empty, FALSE otherwise.
     */
    public static function is_not_empty($value)
    {
        return !empty($value);
    }

    /**
     * Check that input is either 0 or 1.
     *
     * @param mixed $value The input to check
     *
     * @return Boolean $return TRUE if input is a numeric boolean, FALSE otherwise.
     */
    public static function is_numerical_boolean($value)
    {
        return ($value == 1) || ($value == 0);
    }

}

?>
