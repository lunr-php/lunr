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
        if (trim($identifier) != "")
        {
            Output::error("Can't verify input. Empty Identifier!'");
            return FALSE;
        }

        if (!is_array($input) || !is_array($ruleset))
        {
            Output::error("Can't verify input. Invalid input!'");
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
                        if (call_user_func("self::check_" . $rule) === FALSE)
                        {
                            Output::error("Input validation '$identifier': Rule '$rule' failed!");
                            return FALSE;
                        }
                    }
                    unset($rule);
                }
                else
                {
                    if (call_user_func("self::check_" . $ruleset[$key]) === FALSE)
                    {
                        Output::error("Input validation '$identifier': Rule '" . $ruleset[$key] . "' failed!");
                        return FALSE;
                    }
                }
            }
            else
            {
                Output::error("Input validation '$identifier': Unhandled Array Element!");
                return FALSE;
            }
        }

        //Everything looks good
        return TRUE;
    }

}

?>
