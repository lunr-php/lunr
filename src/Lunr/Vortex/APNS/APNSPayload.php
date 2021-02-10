<?php

/**
 * This file contains functionality to generate Apple Push Notification Service payloads.
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS;

use \ReflectionClass;

/**
 * Apple Push Notification Service Payload Generator.
 */
class APNSPayload
{

    /**
     * Array of Push Notification elements.
     * @var array
     */
    protected $elements;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->elements = [];

        $this->elements['priority'] = APNSPriority::HIGH;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->elements);
    }

    /**
     * Construct the payload for the push notification.
     *
     * @return array APNSPayload elements
     */
    public function get_payload()
    {
        return $this->elements;
    }

    /**
     * Sets the payload key collapse_key.
     *
     * An arbitrary string that is used to collapse a group of alike messages
     * when the device is offline, so that only the last message gets sent to the client.
     *
     * @param string $key The notification collapse key identifier
     *
     * @return APNSPayload Self Reference
     */
    public function set_collapse_key($key)
    {
        $this->elements['collapse_key'] = $key;

        return $this;
    }

    /**
     * Sets the payload key topic.
     *
     * An string that is used to identify the notification topic. This is usually the app bundle identifier.
     *
     * @param string $topic The notification topic identifier
     *
     * @return APNSPayload Self Reference
     */
    public function set_topic($topic)
    {
        $this->elements['topic'] = $topic;

        return $this;
    }

    /**
     * Mark the notification priority.
     *
     * @param \Lunr\Vortex\APNS\APNSPriority|int $priority Notification priority value.
     *
     * @return APNSPayload Self Reference
     */
    public function set_priority($priority)
    {
        $priority       = $priority;
        $priority_class = new ReflectionClass('\Lunr\Vortex\APNS\APNSPriority');
        if (in_array($priority, array_values($priority_class->getConstants())))
        {
            $this->elements['priority'] = $priority;
        }

        return $this;
    }

    /**
     * Sets the payload badge index.
     *
     * Used to determine what type of icon to show on the app icon when the message arrives
     *
     * @param integer $badge The badge index
     *
     * @return APNSPayload Self Reference
     */
    public function set_badge($badge)
    {
        $this->elements['badge'] = $badge;

        return $this;
    }

    /**
     * Sets the payload sound.
     *
     * @param string $sound The sound to set it to
     *
     * @return APNSPayload Self Reference
     */
    public function set_sound($sound)
    {
        $this->elements['sound'] = $sound;

        return $this;
    }

    /**
     * Sets the payload thread_id.
     *
     * @param string $thread_id The thread_id to set it to
     *
     * @return APNSPayload Self Reference
     */
    public function set_thread_id($thread_id)
    {
        $this->elements['thread_id'] = $thread_id;

        return $this;
    }

    /**
     * Sets the payload identifier.
     *
     * @param string $identifier The identifier to set it to
     *
     * @return APNSPayload Self Reference
     */
    public function set_identifier($identifier)
    {
        $this->elements['identifier'] = $identifier;

        return $this;
    }

    /**
     * Sets the payload category.
     *
     * @param string $category The category to set it to
     *
     * @return APNSPayload Self Reference
     */
    public function set_category($category)
    {
        $this->elements['category'] = $category;

        return $this;
    }

    /**
     * Sets the payload content_available property.
     *
     * @param boolean $content_available If there is content available for download
     *
     * @return APNSPayload Self Reference
     */
    public function set_content_available($content_available)
    {
        $this->elements['content_available'] = $content_available;

        return $this;
    }

    /**
     * Sets the payload mutable_content property.
     *
     * @param boolean $mutable_content If the notification is mutable
     *
     * @return APNSPayload Self Reference
     */
    public function set_mutable_content($mutable_content)
    {
        $this->elements['mutable_content'] = $mutable_content;

        return $this;
    }

    /**
     * Sets the payload title.
     *
     * @param string $title The actual title
     *
     * @return APNSPayload Self Reference
     */
    public function set_title($title)
    {
        $this->elements['title'] = $title;

        return $this;
    }

    /**
     * Sets the payload body.
     *
     * @param string $body The actual message
     *
     * @return APNSPayload Self Reference
     */
    public function set_body($body)
    {
        $this->elements['body'] = $body;

        return $this;
    }

    /**
     * Sets the payload alert.
     *
     * The alert key represents the actual message to be sent
     * and it is named alert for sake of convention, as this is
     * the name of the key in the actual bytestream payload.
     *
     * @param string $alert The actual message
     *
     * @deprecated use set_body instead
     *
     * @return APNSPayload Self Reference
     */
    public function set_alert($alert)
    {
        return $this->set_body($alert);
    }

    /**
     * Sets custom data in the payload.
     *
     * @param string $key   The key of the custom property
     * @param string $value The value of the custom property
     *
     * @return APNSPayload Self Reference
     */
    public function set_custom_data($key, $value)
    {
        if (!isset($this->elements['custom_data']))
        {
            $this->elements['custom_data'] = [];
        }

        $this->elements['custom_data'][$key] = $value;

        return $this;
    }

}

?>
