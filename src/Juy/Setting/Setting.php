<?php namespace Juy\Setting;

use Illuminate\Support\Facades\Cache;
use Juy\Setting\Model\Setting as Model;

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
		$settings = Cache::rememberForever('setting2', function()
		{
			// Fetch from database
			$settings = Model::get(array('key', 'value'));

			// Convert key -> value array
			$arr = array();
			foreach ($settings as $i)
			{
				$arr[$i->key] = $i->value;
			}

			return $arr;
		});

		return (isset($settings[$key])) ? $settings[$key] : null;
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
		$setting = Model::where('key', '=', $key)->first();

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
			$setting = Model::where('key', '=', $key)->first();

			// Set the values
			$setting->value = $value;
			$setting->save();

			// Expire the cache
			Cache::forget(self::$cacheKey);
		}

		return true;
	}

}
