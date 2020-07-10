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
