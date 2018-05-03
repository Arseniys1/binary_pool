<?php

namespace App\Helpers;


class UserSettings implements \JsonSerializable
{
    private $settings;

    public function __construct($settings)
    {
        $this->setSettings($settings);
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->settings) !== false) {
            return $this->settings[$key];
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param mixed $settings
     */
    public function setSettings($settings): void
    {
        $this->settings = $settings;
    }

    public function jsonSerialize() {
        return $this->settings;
    }
}