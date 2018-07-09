<?php

/**
 * This file contains functionality to generate Firebase Cloud Messaging Push Notification payloads.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\GCM\GCMPayload;

/**
 * Google Cloud Messaging Push Notification Payload Generator.
 */
class FCMPayload extends GCMPayload
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Check whether a condition is set
     *
     * @return boolean $return TRUE if condition is present.
     */
    public function has_condition()
    {
        return isset($this->elements['condition']);
    }

    /**
     * Check whether a condition is set
     *
     * @return boolean $return TRUE if condition is present.
     */
    public function has_topic()
    {
        return isset($this->elements['topic']);
    }

    /**
     * Sets the payload key notification.
     *
     * The fields of data represent the key-value pairs of the message's payload notification data.
     *
     * @param array $notification The actual notification information
     *
     * @return FCMPayload $self Self Reference
     */
    public function set_notification($notification)
    {
        $this->elements['notification'] = $notification;

        return $this;
    }

    /**
     * Sets the notification as low priority.
     *
     * Notifications are high priority by default on iOS and Android,
     * this allows for lower priority.
     *
     * @param boolean $val A boolean indicating that all platforms should
     *                     be send as low priority notifications.
     *
     * @return FCMPayload $self Self Reference
     */
    public function set_low_priority($val)
    {
        $this->elements['priority'] = $val ? 'normal' : 'high';

        return $this;
    }

    /**
     * Sets the notification as providing content.
     *
     * @param boolean $val boolean value for the "content_available" field.
     *
     * @return FCMPayload $self Self Reference
     */
    public function set_content_available($val)
    {
        $this->elements['content_available'] = $val;

        return $this;
    }

    /**
     * Sets the topic name to send the message to.
     *
     * @param string $topic String of the topic name
     *
     * @return FCMPayload $self Self Reference
     */
    public function set_topic($topic)
    {
        $this->elements['topic'] = $topic;

        return $this;
    }

    /**
     * Sets the condition to send the message to. For example:
     * 'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)
     *
     * You can include up to five topics in your conditional expression.
     * Conditions support the following operators: &&, ||, !
     *
     * @param string $condition Key-value pairs of payload data
     *
     * @return FCMPayload $self Self Reference
     */
    public function set_condition($condition)
    {
        $this->elements['condition'] = $condition;

        return $this;
    }

}

?>
