<?php

/**
 * This file contains functionality to generate Firebase Cloud Messaging Push Notification payloads.
 *
 * @package    Lunr\Vortex\GCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\GCM\GCMPayload;
use ReflectionClass;

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
        $this->elements['priority'] = FCMPriority::HIGH;
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
     * Sets the notification as providing content.
     *
     * @param boolean $val Value for the "content_available" field.
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

    /**
     * Mark the notification as mutable.
     *
     * @param boolean $mutable Notification mutable_content value.
     *
     * @return FCMPayload $self Self Reference
     */
    public function set_mutable_content($mutable)
    {
        $this->elements['mutable_content'] = $mutable;

        return $this;
    }

    /**
     * Mark the notification priority.
     *
     * @param Lunr\Vortex\FCM\FCMPriority $priority Notification priority value.
     *
     * @return FCMPayload $self Self Reference
     */
    public function set_priority($priority)
    {
        $priority       = strtolower($priority);
        $priority_class = new ReflectionClass('\Lunr\Vortex\FCM\FCMPriority');
        if (in_array($priority, array_values($priority_class->getConstants())))
        {
            $this->elements['priority'] = $priority;
        }

        return $this;
    }

    /**
     * Set additional FCM values in the 'fcm_options' key.
     *
     * @param string $key   Options key.
     * @param string $value Options value.
     *
     * @return FCMPayload $self Self Reference
     */
    public function set_options($key, $value)
    {
        $this->elements['fcm_options'][$key] = $value;

        return $this;
    }

}

?>
