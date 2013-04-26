<?php

/**
 * This file contains another implementation of a
 * command line argument parser, like getopt.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2009-2013, Heinz Wiesinger, Amsterdam, The Netherlands
 * @copyright  2010-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow;

/**
 * Getopt like command line argument parser. However, it
 * does a few things different from getopt. While getopt
 * only allows one argument per command line option, this
 * class allows more than one argument, as well as optional
 * and obligatory arguments mixed
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class LunrCliParser implements CliParserInterface
{

    /**
     * String defining all possible short options (1 character)
     * @var String
     */
    private $short;

    /**
     * Array containing all possible long options
     * @var array
     */
    private $long;

    /**
     * The arguments passed on command line
     * @var array
     */
    private $args;

    /**
     * Checked/Processed arguments
     * @var array
     */
    private $checked;

    /**
     * "Abstract Syntax Tree" of the passed arguments
     * @var array
     */
    private $ast;

    /**
     * Whether there has been a parse error or not
     * @var boolean
     */
    private $error;

    /**
     * Shared instance of a logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger    Shared instance of a Logger class
     * @param String          $shortopts List of supported short arguments
     * @param array           $longopts  List of supported long arguments (optional)
     */
    public function __construct($logger, $shortopts, $longopts = '')
    {
        $this->short   = $shortopts;
        $this->long    = $longopts;
        $this->args    = array();
        $this->checked = array();
        $this->ast     = array();
        $this->error   = FALSE;
        $this->logger  = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->short);
        unset($this->long);
        unset($this->args);
        unset($this->checked);
        unset($this->ast);
        unset($this->error);
        unset($this->logger);
    }

    /**
     * Parse command line parameters.
     *
     * @return array $ast Array of parameters and their arguments
     */
    public function parse()
    {
        $this->args = $_SERVER["argv"];

        foreach($this->args as $index => $arg)
        {
            if(!in_array($arg, $this->checked) && $index != 0)
            {
                $this->is_opt($arg, $index, TRUE);
            }
        }

        return $this->ast;
    }

    /**
     * Check whether the parsed command line was valid or not.
     *
     * @return boolean $invalid TRUE if the command line was invalid, FALSE otherwise
     */
    public function is_invalid_commandline()
    {
        return $this->error;
    }

    /**
     * Check for command line arguments.
     *
     * @param String  $opt      The command line argument
     * @param Integer $index    The index of the argument within $this->args
     * @param boolean $toplevel Whether we run it from the top or from
     *                          further down in the stack
     *
     * @return boolean $return Success or Failure
     */
    private function is_opt($opt, $index, $toplevel = FALSE)
    {
        array_push($this->checked, $opt);

        if ($opt{0} == '-')
        {
            $param = substr($opt, 1);

            if ($param === FALSE)
            {
                return $this->is_valid_short($opt, $index);
            }

            if($param{0} != '-')
            {
                return $this->is_valid_short($param, $index);
            }

            if (strlen($param) > 1)
            {
                return $this->is_valid_long(substr($param, 1), $index);
            }
            else
            {
                return $this->is_valid_long($opt, $index);
            }
        }
        elseif($toplevel)
        {
            $context = [ 'parameter' => $opt ];
            $this->logger->notice('Superfluous argument: {parameter}', $context);
        }

        return FALSE;
    }

    /**
     * Check whether the given argument is a valid short option.
     *
     * @param String  $opt   The command line argument
     * @param Integer $index The index of the argument within $this->args
     *
     * @return boolean $return Success or Failure
     */
    private function is_valid_short($opt, $index)
    {
        $pos = strpos($this->short, $opt);

        if($pos === FALSE)
        {
            $context = [ 'parameter' => $opt ];
            $this->logger->error('Invalid parameter given: {parameter}', $context);
            $this->error = TRUE;
            return FALSE;
        }

        $this->ast[$opt] = array();

        return $this->check_argument($opt, $index, $pos, $this->short);
    }

    /**
     * Check whether the given argument is a valid long option.
     *
     * @param String  $opt   The command line argument
     * @param Integer $index The index of the argument within $this->args
     *
     * @return boolean $return Success or Failure
     */
    private function is_valid_long($opt, $index)
    {
        $match = FALSE;

        foreach($this->long as $key => $arg)
        {
            if($opt == substr($arg, 0, strlen($opt)))
            {
                if (strlen($arg) == strlen($opt))
                {
                    $match = TRUE;
                    $args  = $key;
                }
                elseif ($arg{strlen($opt)} == ':' || $arg{strlen($opt)} == ';')
                {
                    $match = TRUE;
                    $args  = $key;
                }
            }
        }

        if($match === FALSE)
        {
            $context = [ 'parameter' => $opt ];
            $this->logger->error('Invalid parameter given: {parameter}', $context);
            $this->error = TRUE;
            return FALSE;
        }

        $this->ast[$opt] = array();

        return $this->check_argument($opt, $index, strlen($opt) - 1, $this->long[$args]);
    }

    /**
     * Check whether the given string is a valid argument.
     *
     * @param String  $opt   The command line argument
     * @param Integer $index The index of the argument within $this->args
     * @param Integer $pos   Index of the last option character within the
     *                       longopts or shortopts String
     * @param String  $a     The option the argument belongs too
     *
     * @return boolean $return Success or Failure
     */
    private function check_argument($opt, $index, $pos, $a)
    {
        $next = $index + 1;

        if($pos + 1 < strlen($a))
        {
            if(!in_array($a{$pos + 1}, array(':', ';')))
            {
                return FALSE;
            }

            $type = $a{$pos + 1} == ':' ? ':' : ';';

            if (count($this->args) > $next && strlen($this->args[$next]) != 0)
            {
                if (!$this->is_opt($this->args[$next], $next) && $this->args[$next]{0} != '-')
                {
                    array_push($this->ast[$opt], $this->args[$next]);

                    if ($pos + 2 >= strlen($a))
                    {
                        return TRUE;
                    }

                    if (($type == ':' && $a{$pos + 2} == ':') || $a{$pos + 2} == ';')
                    {
                        return $this->check_argument($opt, $next, $pos + 1, $a);
                    }
                    else
                    {
                        return TRUE;
                    }
                }
                elseif ($type == ':')
                {
                    $context = [ 'parameter' => $opt ];
                    $this->logger->error('Missing argument for -{parameter}', $context);
                    $this->error = TRUE;
                }
            }
            elseif ($type == ':')
            {
                $context = [ 'parameter' => $opt ];
                $this->logger->error('Missing argument for -{parameter}', $context);
                $this->error = TRUE;
            }
        }
        elseif (count($this->args) > $next && !strpos($a, $opt))
        {
            $context = [ 'argument' => $this->args[$next] ];
            $this->logger->notice('Superfluous argument: {argument}', $context);

            return TRUE;
        }

        return FALSE;
    }

}

?>
