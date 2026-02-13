<?php
/**
 * Global Settings Helper
 * 
 * Purpose: Provides a centralized API for retrieving and caching application settings.
 * 
 * Functions: 
 * - get(): Retrieve a single setting with automatic decryption and type casting.
 * - getPublicSettings(): Batch retrieval for frontend-safe settings.
 * - helper methods for Currency, SEO, Payment, and Shipping configurations.
 * 
 * Caching: Uses Laravel Cache to minimize database hits for static configurations.
 */

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Get setting value with caching
     */
    public static function get(string $key, $default = null): mixed
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            $value = $setting->value;

            if ($setting->is_encrypted && $value) {
                $value = decrypt($value);
            }

            // Cast based on type
            switch ($setting->type) {
                case 'boolean':
                case 'checkbox':
                    return filter_var($value, FILTER_VALIDATE_BOOLEAN);
                case 'number':
                case 'integer':
                    return is_numeric($value) ? (int) $value : 0;
                case 'decimal':
                case 'float':
                    return is_numeric($value) ? (float) $value : 0.0;
                case 'array':
                case 'json':
                    return $value ? json_decode($value, true) : [];
                default:
                    return $value ?? '';
            }
        });
    }

    /**
     * Get multiple settings at once
     */
    public static function getMultiple(array $keys): array
    {
        $settings = [];

        foreach ($keys as $key) {
            $settings[$key] = self::get($key);
        }

        return $settings;
    }

    /**
     * Clear settings cache
     */
    public static function clearCache(string $key = null): void
    {
        if ($key) {
            Cache::forget("setting.{$key}");
        } else {
            // Clear all settings cache
            $settings = Setting::pluck('key')->toArray();
            foreach ($settings as $settingKey) {
                Cache::forget("setting.{$settingKey}");
            }
        }
    }

    /**
     * Get all public settings
     */
    public static function getPublicSettings(): array
    {
        return Cache::remember('settings.public', 3600, function () {
            $settings = Setting::where('is_public', true)
                ->orderBy('group')
                ->orderBy('sort_order')
                ->get();

            $result = [];

            foreach ($settings as $setting) {
                $result[$setting->key] = self::getSettingValue($setting);
            }

            return $result;
        });
    }

    /**
     * Get setting value from model
     */
    private static function getSettingValue(Setting $setting): mixed
    {
        $value = $setting->value;

        if ($setting->is_encrypted && $value) {
            $value = decrypt($value);
        }

        // Cast based on type
        switch ($setting->type) {
            case 'boolean':
            case 'checkbox':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'number':
            case 'integer':
                return is_numeric($value) ? (int) $value : 0;
            case 'decimal':
            case 'float':
                return is_numeric($value) ? (float) $value : 0.0;
            case 'array':
            case 'json':
                return $value ? json_decode($value, true) : [];
            default:
                return $value ?? '';
        }
    }

    /**
     * Get currency symbol
     */
    public static function currencySymbol(): string
    {
        $currency = self::get('currency', 'USD');

        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'C$',
            'INR' => '₹'
        ];

        return $symbols[$currency] ?? '$';
    }

    /**
     * Get store information
     */
    public static function storeInfo(): array
    {
        return [
            'name' => self::get('store_name', 'EULOZIA'),
            'email' => self::get('store_email', 'contact@eulozia.com'),
            'phone' => self::get('store_phone', '+1 234 567 8900'),
            'address' => self::get('store_address', '123 Fashion Street, New York, NY 10001, USA'),
            'currency' => self::get('currency', 'USD'),
            'currency_symbol' => self::currencySymbol()
        ];
    }

    /**
     * Get SEO settings
     */
    public static function seoSettings(): array
    {
        return [
            'meta_title' => self::get('meta_title', 'EULOZIA - Premium Fashion & Lifestyle'),
            'meta_description' => self::get('meta_description', 'Discover stunning fashion and lifestyle products at EULOZIA. Find the perfect item for every occasion.'),
            'meta_keywords' => self::get('meta_keywords', 'fashion, lifestyle, accessories, online shopping, trendy'),
            'google_analytics' => self::get('google_analytics', '')
        ];
    }

    /**
     * Get payment settings
     */
    public static function paymentSettings(): array
    {
        return [
            'razorpay_enabled' => self::get('razorpay_enabled', true),
            'razorpay_key_id' => self::get('razorpay_key_id', ''),
            'razorpay_key_secret' => self::get('razorpay_key_secret', ''),
            'cod_enabled' => self::get('cod_enabled', true)
        ];
    }

    /**
     * Get shipping settings
     */
    public static function shippingSettings(): array
    {
        return [
            'default_shipping_rate' => self::get('default_shipping_rate', 99.00),
            'tax_rate' => self::get('tax_rate', 3.0),
            'free_shipping_min' => self::get('free_shipping_min', 999.00)
        ];
    }
}
