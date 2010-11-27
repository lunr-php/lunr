<?php

# Copyright 2009-2010 Heinz Wiesinger, Amsterdam, The Netherlands
# Copyright 2010 M2Mobi BV, Amsterdam, The Netherlands
# All rights reserved.
#
# Redistribution and use of this script, with or without modification, is
# permitted provided that the following conditions are met:
#
# 1. Redistributions of this script must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR ''AS IS'' AND ANY EXPRESS OR IMPLIED
# WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
# MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO
# EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
# SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
# PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
# OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
# WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
# OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
# ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

class CliParser
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
     * Constructor
     * @param array $shortopts List of supported short arguments
     * @param array $longopts List of supported long arguments (optional)
     */
    public function __construct($shortopts,$longopts="")
    {
        $this->short = $shortopts;
        $this->long = $longopts;
        $this->checked = array();
        $this->ast = array();
        $this->error = false;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset($this->short);
        unset($this->long);
        unset($this->args);
        unset($this->checked);
        unset($this->ast);
        unset($this->error);
    }

    /**
     * Parse given arguments
     * @param array $args The arguments given on command line
     * @return array $ast The ast of the parsed arguments
     */
    public function parse_argv($args)
    {
        $this->args = $args;
        foreach($args as $index=>$arg)
        {
            if(!in_array($arg,$this->checked) && $index!=0)
            {
                $this->is_opt($arg,$index,true);
            }
        }
        return $this->ast;
    }

    /**
     * Parse error information
     * @return boolean $error Whether there was a parse error or not
     */
    public function parse_error()
    {
        return $this->error;
    }

    /**
     * Check for command line arguments
     * @param String $opt The command line argument
     * @param Integer $index The index of the argument within $this->args
     * @param boolean $toplevel Whether we run it from the top or from further down in the stack
     * @return boolean $return Success or Failure
     */
    private function is_opt($opt,$index,$toplevel=false)
    {
        array_push($this->checked,$opt);
        if (strlen($opt)!=0)
        {
            if ($opt{0}=="-")
            {
                $param = substr($opt,1);
                if (strlen($param)!=0)
                {
                    if($param{0}=="-")
                    {
                        return $this->is_valid_long(substr($param,1),$index);
                    }
                    else
                    {
                        return $this->is_valid($param,$index);
                    }
                }
                else
                {
                    return $this->is_valid($param,$index);
                }
            }
            elseif($toplevel)
            {
                echo "Superfluos argument: $opt\n";
            }
        }
        return false;
    }

    /**
     * Check whether the given argument is a valid short option
     * @param String $opt The command line argument
     * @param Integer $index The index of the argument within $this->args
     * @return boolean $return Success or Failure
     */
    private function is_valid($opt,$index)
    {
        $pos=strpos($this->short,$opt);
        if($pos!==false)
        {
            $this->ast[$opt] = array();
            return $this->check_argument($opt,$index,$pos,$this->short);
        }
        else
        {
            echo "Invalid parameter given: -".$opt."\n";
            $this->error = true;
        }
        return false;
    }

    /**
     * Check whether the given argument is a valid long option
     * @param String $opt The command line argument
     * @param Integer $index The index of the argument within $this->args
     * @return boolean $return Success or Failure
     */
    private function is_valid_long($opt,$index)
    {
        $match = false;
        foreach($this->long as $key=>$arg)
        {
            if($opt==substr($arg,0,strlen($opt)))
            {
                if (strlen($arg)==strlen($opt))
                {
                    $match = true;
                    $args = $key;
                }
                elseif ($arg{strlen($opt)}==":" || $arg{strlen($opt)}==";")
                {
                    $match = true;
                    $args = $key;
                }
            }
        }
        if($match)
        {
            $this->ast[$opt] = array();
            return $this->check_argument($opt,$index,strlen($opt)-1,$this->long[$args]);
        }
        else
        {
            echo "Invalid parameter given: --".$opt."\n";
            $this->error = true;
            return false;
        }
    }

    /**
     * Check whether the given string is a valid argument for either a short or long option
     * @param String $opt The command line argument
     * @param Integer $index The index of the argument within $this->args
     * @param Integer $pos Index of the last option character within the longopts or shortopts String
     * @param String $a The option the argument belongs too
     * @return boolean $return Success or Failure
     */
    private function check_argument($opt,$index,$pos,$a)
    {
        $next = $index+1;
        if($pos+1<strlen($a))
        {
            if($a{$pos+1}==":")
            {
                if (count($this->args)>$next)
                {
                    if (!$this->is_opt($this->args[$next],$next) && $this->args[$next]{0}!="-")
                    {
                        array_push($this->ast[$opt],$this->args[$next]);
                        if ($pos+2<strlen($a))
                        {
                            if ($a{$pos+2}==":" || $a{$pos+2}==";")
                            {
                                return $this->check_argument($opt,$next,$pos+1,$a);
                            }
                            else
                            {
                                return true;
                            }
                        }
                        else
                        {
                            return true;
                        }
                    }
                    else
                    {
                        echo "Missing argument for -".$opt."\n";
                        $this->error = true;
                    }
                }
                else
                {
                    echo "Missing argument for -".$opt."\n";
                    $this->error = true;
                }
            }
            elseif($a{$pos+1}==";")
            {
                if (count($this->args)>$next && strlen($this->args[$next])!=0)
                {
                    if (!$this->is_opt($this->args[$next],$next) && $this->args[$next]{0}!="-")
                    {
                        array_push($this->ast[$opt],$this->args[$next]);
                        if ($pos+2<strlen($a))
                        {
                            if ($a{$pos+2}==";")
                            {
                                return $this->check_argument($opt,$next,$pos+1,$a);
                            }
                            else
                            {
                                return true;
                            }
                        }
                    }
                    else
                    {
                        //echo "Missing optional argument for -".$opt."\n";
                    }
                }
                else
                {
                    //echo "Missing optional argument for -".$opt."\n";
                }
            }
            elseif (count($this->args)>$next && !strpos($a,$opt))
            {
                if (!$this->is_opt($this->args[$next],$next))
                {
                    echo "Superfluos argument: ".$this->args[$next]."\n";
                }
                return true;
            }
        }
        return false;
    }

}

?>