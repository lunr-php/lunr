<?php

/**
 * This file contains an input array content verification system.
 * Additionally there are some other public verification methods.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Flare
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Flare;

/**
 * Verification class
 *
 * @category   Libraries
 * @package    Flare
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Verification
{

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The dataset to verify.
     * @var array
     */
    private $data;

    /**
     * Pointer to the element in the dataset to inspect.
     * @var mixed
     */
    protected $pointer;

    /**
     * Set of results for all checks performed on the input dataset
     * @var array
     */
    protected $result;

    /**
     * Set of rulesets for non-existing keys.
     * @var array
     */
    private $superfluous;

    /**
     * Identifier for the verification process.
     * Used in the log file.
     * @var String
     */
    private $identifier;

    /**
     * Flag whether to check for superfluous rules or not.
     * @var Boolean
     */
    private $check_superfluous;

    /**
     * Flag whether to check for unchecked indexes or not.
     * @var Boolean
     */
    private $check_remaining;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger Shared instance of a Logger class
     */
    public function __construct($logger)
    {
        $this->logger = $logger;

        $this->data    = array();
        $this->result  = array();
        $this->pointer = NULL;

        $this->superfluous = array();
        $this->identifier  = '';

        $this->check_remaining   = TRUE;
        $this->check_superfluous = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);
        unset($this->pointer);
        unset($this->superfluous);
        unset($this->result);
        unset($this->identifier);
        unset($this->check_remaining);
        unset($this->check_superfluous);
    }

    /**
     * Catch unimplemented functions.
     *
     * @param String $method    Method name
     * @param array  $arguments Arguments to that method
     *
     * @return Verification $self Self reference
     */
    public function __call($method, $arguments)
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $this->result[$this->pointer][$method] = FALSE;

        return $this;
    }

    /**
     * Set the data we want to verify.
     *
     * @param array &$dataset The dataset we are going to verify
     *
     * @return Verification $self Self reference
     */
    public function set_data(&$dataset)
    {
        if (is_array($dataset) && !empty($dataset))
        {
            $this->data =& $dataset;
        }
        else
        {
            $this->logger->error("Can't verify input dataset! Invalid dataset format.");

            # don't verify stale input against new ruleset
            if (!empty($this->data))
            {
                $this->data = array();
            }
        }

        $this->check_remaining   = TRUE;
        $this->check_superfluous = FALSE;

        $this->superfluous = array();
        $this->result      = array();
        $this->pointer     = NULL;
        $this->identifier  = '';

        return $this;
    }

    /**
     * Set an identifier for the verification process.
     *
     * This identifier is used in the error log and can be used
     * to distinguish errors from multiple verification runs
     * from each other.
     *
     * @param String $identifier Identifier for the Verification process
     *
     * @return Verification $self Self reference
     */
    public function set_identifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * Don't check for unchecked indexes.
     *
     * @return Verification $self Self reference
     */
    public function ignore_unchecked_indexes()
    {
        $this->check_remaining = FALSE;
        return $this;
    }

    /**
     * Check for checks performed on non-existing indexes.
     *
     * @return Verification $self Self reference
     */
    public function check_superfluous_checks()
    {
        $this->check_superfluous = TRUE;
        return $this;
    }

    /**
     * Set the index of the dataset to inspect.
     *
     * @param mixed $index Dataset index
     *
     * @return Verification $self Self reference
     */
    public function inspect($index)
    {
        if (isset($this->data[$index]))
        {
            $this->pointer = $index;
        }
        else
        {
            $this->pointer       = NULL;
            $this->superfluous[] = $index;
        }

        return $this;
    }

    /**
     * Go over the results and check whether the input dataset can be verified or not.
     *
     * @return Boolean $return TRUE if the input dataset is valid, FALSE otherwise
     */
    public function is_valid()
    {
        if (trim($this->identifier) == '')
        {
            $this->logger->error("Can't verify input. Empty Identifier!'");
            return FALSE;
        }

        $valid = TRUE;

        $error_prefix = "Input validation '" . $this->identifier . "': ";

        # Check for superfluous checks
        if ($this->check_superfluous === TRUE)
        {
            $result = $this->is_overchecked($error_prefix);
            if ($result === TRUE)
            {
                return FALSE;
            }
        }

        # Check for unchecked indexes
        if ($this->check_remaining === TRUE)
        {
            $result = $this->is_fully_checked($error_prefix);
            if ($result === FALSE)
            {
                return FALSE;
            }
        }

        $message = "Rule '{rule}' failed for '{index}' with value '{val}' of type '{type}'!";
        $context = array();

        foreach($this->result as $index => $checks)
        {
            # check if index was ignored
            if ($checks === TRUE)
            {
                continue;
            }

            foreach ($checks as $rule => $result)
            {
                if ($result !== TRUE)
                {
                    $context['rule']  = $rule;
                    $context['index'] = $index;
                    $context['val']   = print_r($this->data[$index], TRUE);
                    $context['type']  = gettype($this->data[$index]);

                    $this->logger->error($message, $context);

                    $valid = FALSE;
                }
            }
        }

        return $valid;
    }

    /**
     * Verify that there are no checks for non-existing indexes.
     *
     * @param String $error_prefix Prefix string for the error logging
     *
     * @return Boolean $return TRUE if no non-existing indexes have been checked, FALSE otherwise
     */
    private function is_overchecked($error_prefix)
    {
        if (empty($this->superfluous))
        {
            return FALSE;
        }

        $message = $error_prefix . "Ruleset for non-existing key '{key}'!";
        $context = array();

        foreach ($this->superfluous as &$value)
        {
            $context['key'] = $value;

            $this->logger->error($message, $context);
        }

        unset($value);

        return TRUE;
    }

    /**
     * Verify that every index in the input set has been checked.
     *
     * @param String $error_prefix Prefix string for the error logging
     *
     * @return Boolean $return TRUE if everything has been checked, FALSE otherwise
     */
    private function is_fully_checked($error_prefix)
    {
        // Check that input matches with the defined ruleset
        $data_indexes       = array_keys($this->data);
        $checked_indexes    = array_keys($this->result);
        $unhandled_elements = array_diff($data_indexes, $checked_indexes);

        if ($unhandled_elements == array())
        {
            return TRUE;
        }

        $message = $error_prefix . "Unhandled Index '{index}'!";
        $context = array();

        foreach ($unhandled_elements as $value)
        {
            $context['index'] = $value;

            $this->logger->error($message, $context);
        }

        return FALSE;
    }

    /**
     * Don't perform specific checks on the selected index.
     *
     * @return Verification $self Self reference
     */
    public function ignore()
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $this->result[$this->pointer] = TRUE;
        $this->pointer                = NULL;

        return $this;
    }

    /**
     * Check character length of an input.
     *
     * @param Integer $length The length to check for
     *
     * @return Verification $self Self reference
     */
    public function is_length($length)
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $this->result[$this->pointer]['is_length_' . $length] = (strlen($this->data[$this->pointer]) === $length);

        return $this;
    }

    /**
     * Check that input is of the type provided as parameter.
     *
     * @param mixed $type The type to check for
     *
     * @return Verification $self Self reference
     */
    public function is_type($type)
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $f = 'is_' . $type;
        if (function_exists($f))
        {
            $this->result[$this->pointer]['is_type_' . $type] = $f($this->data[$this->pointer]);
        }
        else
        {
            $this->result[$this->pointer]['is_type_' . $type] = FALSE;
        }

        return $this;
    }

    /**
     * Check that an input is not empty.
     *
     * Note that 0 and "0" are also considered empty.
     *
     * @return Verification $self Self reference
     */
    public function is_not_empty()
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $this->result[$this->pointer]['is_not_empty'] = !empty($this->data[$this->pointer]);

        return $this;
    }

    /**
     * Check that input is either 0 or 1.
     *
     * @return Verification $self Self reference
     */
    public function is_numerical_boolean()
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $this->result[$this->pointer]['is_numerical_boolean'] =
            ($this->data[$this->pointer] === 1) || ($this->data[$this->pointer] === 0) ||
            ($this->data[$this->pointer] === '0') || ($this->data[$this->pointer] === '1');

        return $this;
    }

    /**
     * Check that input is a valid email.
     *
     * @param Mail $mail Instance of the Mail class
     *
     * @return Verification $self Self reference
     */
    public function is_mail($mail)
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $this->result[$this->pointer]['is_mail'] = $mail->is_valid($this->data[$this->pointer]);

        return $this;
    }

    /**
     * Check whether input is a numerical troolean (values 0,1,2).
     *
     * @return Verification $self Self reference
     */
    public function is_numerical_troolean()
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $this->result[$this->pointer]['is_numerical_troolean'] =
            ($this->data[$this->pointer] === 0) || ($this->data[$this->pointer] === 1) ||
            ($this->data[$this->pointer] === 2) || ($this->data[$this->pointer] === '0') ||
            ($this->data[$this->pointer] === '1') || ($this->data[$this->pointer] === '2');

        return $this;
    }

    /**
     * Check whether input is a valid date definition.
     *
     * @param DateTime $datetime Instance of the DateTime class
     *
     * @return Verification $self Self reference
     */
    public function is_date($datetime)
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $this->result[$this->pointer]['is_date'] = $datetime->is_date($this->data[$this->pointer]);

        return $this;
    }

    /**
     * Check whether input is a valid time definition.
     *
     * @param DateTime $datetime Instance of the DateTime class
     *
     * @return Verification $self Self reference
     */
    public function is_time($datetime)
    {
        if ($this->pointer === NULL)
        {
            return $this;
        }

        $this->result[$this->pointer]['is_time'] = $datetime->is_time($this->data[$this->pointer]);

        return $this;
    }

}

?>
