<?php

/**
 * This file contains a class to save a common message
 * object for all the social networks
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Julio Foulquié <julio@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

/**
 * Social Message Class
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Julio Foulquié <julio@m2mobi.com>
 */
class SocialMessage
{

    /**
     * Message to be posted
     * @var String
     */
    private $message;

    /**
     * Comment for the main message
     * @var String
     */
    private $comment;

    /**
     * URL to append to the message
     * @var String
     */
    private $url;

    /**
     * URL for an image to add to the message
     * @var String
     */
    private $image_url;

    /**
     * Visibility properties for the current message
     * @var String
     */
    private $visibility;

    /**
     * Constructor.
     *
     * @param String $msg Main message string (empty by default)
     */
    public function __construct($msg = '')
    {
        $this->message = $msg;
    }

     /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->message);
        unset($this->comment);
        unset($this->url);
        unset($this->image_url);
        unset($this->visibility);
    }

    /**
     * Set the value of the private properties of the class.
     *
     * @param String $key Name of the parameter that will be modified
     * @param String $val Value that will be set
     *
     * @return void
     */
    public function __set($key, $val)
    {
        $this->$key = $val;
    }

    /**
     * Get the value of the private properties of the class.
     *
     * @param String $key Name of the property that will be retrieved
     *
     * @return Mixed Value of the key on the class
     */
    public function __get($key)
    {
        return $this->$key;
    }

}

?>
