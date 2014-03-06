<?php namespace Juy\Setting;

use Illuminate\Support\Facades\Cache;

class Setting {

	public static function get($key)
	{
		// Setup cache key
		$cacheKey = 'setting_' . md5($key);

		// Check if in cache
		if (Cache::has($cacheKey))
		{
			return Cache::get($cacheKey);
		}

		// Fetch from database
		$setting = Model\Setting::where('key', '=', $key)->first();

		// If a row was found, return the value
		if (is_object($setting) && $setting->getId())
		{
			// Store in cache
			Cache::forever($cacheKey, $setting->value);

			// Return the data
			return $setting->value;
		}

		return null;
	}

	public static function set($key, $value)
	{
		// Setup cache key
		$cacheKey = 'setting_' . md5($key);

		// Fetch from database
		$setting = Model\Setting::where('key', '=', $key)->first();

		// If nothing was found, create a new object
		if (!is_object($setting))
		{
			$setting = new Model\Setting();
		}

		// Set the values
		$setting->value = $value;
		$setting->save();

		// Expire the cache
		Cache::forget($cacheKey);

		return true;
	}

	public static function insert($data = array())
	{
		foreach ($data as $key => $value)
		{
			$key = str_replace('_', '.', $key);

			// Setup cache key
			$cacheKey = 'setting_' . md5($key);

			// Fetch from database
			$setting = Model\Setting::where('key', '=', $key)->first();

			// Set the values
			$setting->value = $value;
			$setting->save();

			// Expire the cache
			Cache::forget($cacheKey);
		}

		return true;
	}

}
