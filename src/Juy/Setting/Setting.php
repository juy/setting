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
	 *
	 * @return null
	 */
	public function get($key)
	{
		if (Cache::has($this->cacheKey))
		{
			$settings = Cache::get($this->cacheKey);
		}
		else
		{
			try
			{
				// Fetch from database
				$settings = Model::get(array('key', 'value'));

				// Convert key -> value array
				$arr = array();
				foreach ($settings as $i)
				{
					$arr[$i->key] = $i->value;
				}

				Cache::forever($this->cacheKey, $arr);
			}
			catch(\Exception $e)
			{
				return false;
			}
		}


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
	public function set($key, $value)
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
