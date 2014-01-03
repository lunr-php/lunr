<?php

/**
 * This file contains a class to save a common profile
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
 * Social Profile Class
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Julio Foulquié <julio@m2mobi.com>
 */
class SocialProfile
{

    /**
     * e-Mail of the user
     * @var String
     */
    private $email;

    /**
     * First name
     * @var String
     */
    private $given_name;

    /**
     * Family name
     * @var String
     */
    private $last_name;

    /**
     * Gender
     * @var String
     */
    private $gender;

    /**
     * Age
     * @var String
     */
    private $age;

    /**
     * Street
     * @var String
     */
    private $street;

    /**
     * House Number
     * @var String
     */
    private $house_nr;

    /**
     * Post Code
     * @var String
     */
    private $zip;

    /**
     * City
     * @var String
     */
    private $city;

    /**
     * Country
     * @var String
     */
    private $country;

    /**
     * Phone number
     * @var String
     */
    private $phone;

    /**
     * Constructor.
     */
    public function __construct()
    {

    }

     /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->email);
        unset($this->given_name);
        unset($this->last_name);
        unset($this->gender);
        unset($this->age);
        unset($this->street);
        unset($this->house_nr);
        unset($this->zip);
        unset($this->city);
        unset($this->country);
        unset($this->phone);
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
