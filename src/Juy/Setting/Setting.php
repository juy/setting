<?php namespace Juy\Setting;

use Illuminate\Support\Facades\Cache;
use Juy\Setting\Model\Setting as Model;

class Setting {

	/**
	 * Cache key
	 *
	 * @var string
	 */
	private $cacheKey = 'setting';

	/**
	 * Get setting key to value
	 *
	 * @param $key
	 * @param $default
	 *
	 * @return null
	 */
	public function get($key, $default = null)
	{
		try
		{
			$settings = Cache::rememberForever($this->cacheKey, function()
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

			return (isset($settings[$key])) ? $settings[$key] : ( ($default) ? $default : null );
		}
		catch(\Exception $e)
		{
			return null;
		}
	}

	/**
	 * Set setting key to value
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return bool
	 */
	public function set($key, $value)
	{
		// Fetch from database
		$setting = Model::where('key', '=', $key)->first();

		// If nothing was found, create a new object
		if (!is_object($setting))
		{
			$setting = new Model();
			$setting->key = $key;
		}

		// Set the values
		$setting->value = $value;
		$setting->save();

		// Expire the cache
		Cache::forget($this->cacheKey);

		return true;
	}

	/**
	 * Get settings from array
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function insert($data = array())
	{
		foreach ($data as $key => $value)
		{
			// Fetch from database
			$setting = Model::where('key', '=', $key)->first();

			// Set the values
			$setting->value = $value;
			$setting->save();

			// Expire the cache
			Cache::forget($this->cacheKey);
		}

		return true;
	}

}
