<?php namespace Juy\Setting;

use Illuminate\Support\Facades\Cache;

class Setting {

	/**
	 * Cache key
	 *
	 * @var string
	 */
	private static $cacheKey = 'setting';

	/**
	 * Get setting key to value
	 *
	 * @param $key
	 *
	 * @return null
	 */
	public static function get($key)
	{
		// Fetch from cache or database
		$settings = Cache::rememberForever(self::$cacheKey, function()
		{
			return Model\Setting::all()->toArray();
		});

		// Convert key -> value array
		foreach ($settings as $i)
		{
			if ($key == $i['key'])
			{
				return $i['value'];
			}
		}

		return null;
	}

	/**
	 * Set setting key to value
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return bool
	 */
	public static function set($key, $value)
	{
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
		Cache::forget(self::$cacheKey);

		return true;
	}

	/**
	 * Get settings from array
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public static function insert($data = array())
	{
		foreach ($data as $key => $value)
		{
			// Fetch from database
			$setting = Model\Setting::where('key', '=', $key)->first();

			// Set the values
			$setting->value = $value;
			$setting->save();

			// Expire the cache
			Cache::forget(self::$cacheKey);
		}

		return true;
	}

}
