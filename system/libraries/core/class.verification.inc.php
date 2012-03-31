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
     * Log file to store verification errors.
     * @var string
     */
    private $logfile;

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
     * @param Configuration &$configuration Reference to the Configuration class
     * @param Logger        &$logger        Reference to the Logger class
     */
    public function __construct(&$configuration, &$logger)
    {
        $this->configuration =& $configuration;
        $this->logger =& $logger;

        $this->data    = array();
        $this->result  = array();
        $this->pointer = NULL;

        $this->superfluous = array();
        $this->logfile     = '';
        $this->identifier  = '';

        $this->check_remaining   = TRUE;
        $this->check_superfluous = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->configuration = NULL;
        $this->logger = NULL;
        $this->data   = NULL;

        unset($this->pointer);
        unset($this->superfluous);
        unset($this->result);
        unset($this->logfile);
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
            $this->logger->log_error("Can't verify input dataset!");

            # don't verify stale input against new ruleset
            if (!empty($this->data))
            {
                $this->data = array();
            }
        }

        return $this;
    }

    /**
     * Set a log-file for error output.
     *
     * @param String $file Full path to log-file
     *
     * @return Verification $self Self reference
     */
    public function set_log_file($file)
    {
        $this->logfile = $file;
        return $this;
    }

    /**
     * Set an identifier for the verification process.
     *
     * This idenitifier is used in the error log and can be used
     * to distinguish errors from multiple verification runs
     * from each other.
     *
     * @param String $idenitifier Identifier for the Verification process
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
            $this->pointer = NULL;
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
            $this->logger->log_errorln("Can't verify input. Empty Identifier!'", $this->logfile);
            return FALSE;
        }

        $valid = TRUE;

        $error_prefix = "Input validation '" . $this->identifier . "': ";

        # Check for superfluous checks
        if ($this->check_superfluous === TRUE)
        {
            $result = $this->is_overchecked($error_prefix);
            if ($result === FALSE)
            {
                return FALSE;
            }
        }

        # Check for unchecked indexes
        if ($this->check_remaining === TRUE)
        {
            $result = $this->is_fully_checked();
            if ($result === FALSE)
            {
                return FALSE;
            }
        }

        foreach($this->result as $index=>$checks)
        {
            # check if index was ignored
            if ($checks === TRUE)
            {
                continue;
            }

            foreach ($checks as $rule=>$result)
            {
                if ($result !== TRUE)
                {
                    $val  = print_r($this->data[$index], TRUE);
                    $type = gettype($this->data[$index]);
                    $msg  = "Rule '$rule' failed for '$index' with value '$val' of type '$type'!";
                    $this->logger->log_errorln($error_prefix . $msg, $this->logfile);

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
            return TRUE;
        }

        foreach ($this->superfluous as &$value)
        {
            $this->logger->log_errorln($error_prefix . "Ruleset for non-existing key '$value'!", $this->logfile);
        }
        unset($value);

        return FALSE;
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
        $data_indexes    = array_keys($this->data);
        $checked_indexes = array_keys($this->result);
        $unhandled_elements = array_diff($data_indexes, $checked_indexes);

        if ($unhandled_elements == array())
        {
            return TRUE;
        }

        foreach ($unhandled_elements as $value)
        {
            $this->logger->log_errorln($error_prefix . "Unhandled Index '$value'!", $this->logfile);
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
        $this->pointer = NULL;

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
     * @param mixed $type  The type to check for
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
        $this->result[$this->pointer]['is_type_' . $type] = $f($this->data[$this->pointer]);

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
            ($this->data[$this->pointer] === 1)   || ($this->data[$this->pointer] === 0) ||
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
            ($this->data[$this->pointer] === 0)   || ($this->data[$this->pointer] === 1)   ||
            ($this->data[$this->pointer] === 2)   || ($this->data[$this->pointer] === '0') ||
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
