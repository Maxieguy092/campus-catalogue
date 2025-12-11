<?php

namespace App\Helpers;

class LocationHelper
{
    private static $data = null;

    /**
     * Load Indonesian provinces and cities from JSON
     */
    public static function loadData()
    {
        if (self::$data === null) {
            $jsonPath = public_path('json/indonesia_full.json');
            if (file_exists($jsonPath)) {
                self::$data = json_decode(file_get_contents($jsonPath), true);
            } else {
                self::$data = [];
            }
        }
        return self::$data;
    }

    /**
     * Get all provinces
     */
    public static function getProvinces()
    {
        $data = self::loadData();
        return array_keys($data);
    }

    /**
     * Get cities/districts by province
     */
    public static function getCities($province)
    {
        $data = self::loadData();
        return $data[$province] ?? [];
    }

    /**
     * Get all provinces as key-value array for select dropdown
     */
    public static function getProvincesArray()
    {
        $provinces = self::getProvinces();
        return array_combine($provinces, $provinces);
    }

    /**
     * Get cities as key-value array for select dropdown
     */
    public static function getCitiesArray($province)
    {
        $cities = self::getCities($province);
        return array_combine($cities, $cities);
    }
}
