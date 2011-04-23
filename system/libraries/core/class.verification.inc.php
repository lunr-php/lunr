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
        if (substr($method, 0, 12) == "check_length")
        {
            $length = substr($method, 12);
            return self::check_length($length, $arguments[0]);
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Verify an input array against a defined ruleset.
     *
     * @param String $identifier Identifier for the rule-checking
     * @param array  &$input     Input array
     * @param array  &$ruleset   Ruleset to check against
     *
     * @return Boolean $return TRUE if the input matches against the ruleset,
     *                         FALSE otherwise.
     */
    public static function verify_array_ruleset($identifier, &$input, &$ruleset)
    {
        if (trim($identifier) == "")
        {
            Output::error("Can't verify input. Empty Identifier!'");
            return FALSE;
        }

        if (!is_array($input) || !is_array($ruleset))
        {
            Output::error("Can't verify input. Invalid input!'");
            return FALSE;
        }

        // Check that input matches with the defined ruleset
        $input_elements = array_keys($input);
        $ruleset_elements = array_keys($ruleset);
        $unhandled_elements = array_diff($ruleset_elements, $input_elements);

        if ($unhandled_elements != array())
        {
            foreach ($unhandled_elements as $value)
            {
                Output::error("Input validation '$identifier': Ruleset for non-existing key '$value'!");
            }
            return FALSE;
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
                        if (call_user_func("self::check_" . $rule, $value) === FALSE)
                        {
                            Output::error("Input validation '$identifier': Rule '$rule' failed for '$key'!");
                            return FALSE;
                        }
                    }
                    unset($rule);
                }
                else
                {
                    if (call_user_func("self::check_" . $ruleset[$key], $value) === FALSE)
                    {
                        Output::error("Input validation '$identifier': Rule '" . $ruleset[$key] . "' failed for '$key'!");
                        return FALSE;
                    }
                }
            }
            else
            {
                Output::error("Input validation '$identifier': Unhandled Array Element '$key'!");
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
    public static function check_length($length, &$value)
    {
        if (strlen($value) == $length)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

}

?>
