<?php

namespace App\Core\Supports;

use App\Models\Setting;

class MetaHelper
{
    protected static $settings = null;

    protected static function loadSettings()
    {
        if (self::$settings === null) {
            self::$settings = Setting::getAll();
        }
    }

    public static function getTitle($customTitle = null)
    {
        self::loadSettings();
        return isset($customTitle) && trim($customTitle) !== ''
            ? $customTitle
            : (self::$settings['site_name'] ?? config('app.name'));
    }

    public static function getDescription($customDescription = null)
    {
        self::loadSettings();
        return $customDescription ?? (self::$settings['meta_description'] ?? 'Default Description');
    }

    public static function getKeywords($customKeywords = null)
    {
        self::loadSettings();
        return $customKeywords ?? (self::$settings['meta_keywords'] ?? 'default, keywords');
    }
}
