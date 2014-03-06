<?php namespace Juy\Setting\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

	protected $table = 'settings';
	protected $guarded = array('id');
	public $timestamps = false;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param $key
	 * @return $this
	 */
	public function setKey($key)
	{
		$this->key = $key;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function setValue($value)
	{
		$this->value = $value;

		return $this;
	}

}
