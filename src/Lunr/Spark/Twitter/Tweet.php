<?php

/**
 * This file contains Tweet support for Twitter.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter;

use Lunr\Spark\DataError;

/**
 * Twitter Tweet Support for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 */
class Tweet
{

    /**
     * Tweet data.
     * @var Array
     */
     protected $data;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->data);
    }

    /**
     * Retrieve user profile info.
     *
     * @param String $name      Name of the field to get
     * @param Array  $arguments Arguments passed on call (Ignored)
     *
     * @return mixed $value Field value
     */
    public function __call($name, $arguments)
    {
        $item = str_replace('get_', '', $name);

        switch ($item)
        {
            case 'annotations':
            case 'contributors':
            case 'coordinates':
            case 'created_at':
            case 'current_user_retweet':
            case 'entities':
            case 'favorite_count':
            case 'favorited':
            case 'filter_level':
            case 'id':
            case 'id_str':
            case 'in_replay_to_screen_name':
            case 'in_replay_to_status_id':
            case 'in_replay_to_status_id':
            case 'in_replay_to_status_id_str':
            case 'in_replay_to_user_id':
            case 'in_replay_to_user_id_str':
            case 'lang':
            case 'place':
            case 'possibly_sensitive':
            case 'scopes':
            case 'retweeted':
            case 'retweeted_status':
            case 'source':
            case 'text':
            case 'truncated':
            case 'user':
            case 'withheld_copyright':
            case 'withheld_in_countries':
            case 'withheld_scope':
                return isset($this->data[$item]) ? $this->data[$item] : DataError::NOT_AVAILABLE;
            default:
                return DataError::UNKNOWN_FIELD;
        }

        return isset($this->data[$item]) ? $this->data[$item] : DataError::NOT_AVAILABLE;
    }

    /**
     * Sets the tweet data with the given information.
     *
     * @param array $data Array with tweet data.
     *
     * @return void
     */
    public function set_data($data)
    {
        $this->data = $data;

        return $this;
    }

}

?>
