<?php

/**
 * This file contains functionality to generate JPush payloads.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush;

/**
 * JPush Payload Generator.
 */
abstract class JPushPayload
{

    /**
     * Array of Push Notification elements.
     * @var array
     */
    protected $elements;

    /**
     * Supported push platforms
     * @var array
     */
    const PLATFORMS = ['ios', 'android'];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->elements = [];

        $this->elements['platform']     = self::PLATFORMS;
        $this->elements['audience']     = [];
        $this->elements['notification'] = [];
        $this->elements['message'] = [];
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
     * @return array JPushPayload
     */
    public abstract function get_payload();

    /**
     * Sets the notification identifier.
     *
     * @param string $identifier The notification identifier
     *
     * @return JPushPayload Self Reference
     */
    public function set_notification_identifier($identifier)
    {
        $this->elements['cid'] = $identifier;

        return $this;
    }

    /**
     * Sets the notification message payload.
     *
     * @param string $message The notification body
     *
     * @return JPushPayload Self Reference
     */
    public function set_body($message)
    {
        return $this->set_message_data('msg_content', $message)
                    ->set_notification_data('alert', $message);
    }

    /**
     * Sets the notification title payload.
     *
     * @param string $message The notification title
     *
     * @return JPushPayload Self Reference
     */
    public function set_title($message)
    {
        return $this->set_message_data('title', $message)
                    ->set_notification_data('title', $message, ['android']);
    }

    /**
     * Sets the payload key data.
     *
     * The fields of data represent the key-value pairs of the message's payload data.
     *
     * @param array $data The actual notification information
     *
     * @return JPushPayload Self Reference
     */
    public function set_data($data)
    {
        return $this->set_message_data('extras', $data)
                    ->set_notification_data('extras', $data);
    }

    /**
     * Sets the payload category data.
     *
     * @param string $category The notification category
     *
     * @return JPushPayload Self Reference
     */
    public function set_category($category)
    {
        return $this->set_message_data('content_type', $category)
                    ->set_notification_data('category', $category);
    }

    /**
     * Sets the payload key time_to_live.
     *
     * It defines how long (in seconds) the message should be kept on JPush storage,
     * if the device is offline.
     *
     * @param integer $ttl The time in seconds for the notification to stay alive
     *
     * @return JPushPayload Self Reference
     */
    public function set_time_to_live($ttl)
    {
        $this->set_options('time_to_live', $ttl);

        return $this;
    }

    /**
     * Sets the payload key collapse_key.
     *
     * An arbitrary string that is used to collapse a group of alike messages
     * when the device is offline, so that only the last message gets sent to the client.
     *
     * @param string $key The notification collapse key identifier
     *
     * @return JPushPayload Self Reference
     */
    public function set_collapse_key($key)
    {
        $this->set_options('apns_collapse_id', $key);

        return $this;
    }

    /**
     * Set additional JPush values in the 'options' key.
     *
     * @param string $key   Options key.
     * @param string $value Options value.
     *
     * @return JPushPayload Self Reference
     */
    public function set_options($key, $value)
    {
        if (!isset($this->elements['options']))
        {
            $this->elements['options'] = [];
        }

        $this->elements['options'][$key] = $value;

        return $this;
    }

    /**
     * Set notification value for one or more platforms.
     *
     * @param string   $key       The key in the notification->platform object.
     * @param mixed    $value     The value accompanying that key.
     * @param string[] $platforms The platforms to apply this to.
     *
     * @return JPushPayload Self Reference
     */
    protected function set_notification_data($key, $value, $platforms = self::PLATFORMS)
    {
        foreach ($platforms as $platform)
        {
            $this->elements['notification'][$platform][$key] = $value;
        }

        return $this;
    }

    /**
     * Set notification value for one or more platforms.
     *
     * @param string   $key       The key in the notification->platform object.
     * @param mixed    $value     The value accompanying that key.
     *
     * @return JPushPayload Self Reference
     */
    protected function set_message_data($key, $value)
    {
        $this->elements['message'][$key] = $value;

        return $this;
    }

}

?>
