<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method TagRow|FALSE fetch()
 * @method TagRow|FALSE get($key)
 * @method TagRow|FALSE current()
 * @method TagSelection where($condition, $parameters = [])
 * @method TagRow insert($data)
 */
class TagGeneratedSelection extends BaseSelection
{

	/**
	 * @param int $value
	 * @return TagSelection
	 */
	public function whereId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param string $value
	 * @return TagSelection
	 */
	public function whereName($value)
	{
		return $this->where('name', $value);
	}


	/**
	 * @param int $value
	 * @return TagSelection
	 */
	public function withId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param string $value
	 * @return TagSelection
	 */
	public function withName($value)
	{
		return $this->where('name', $value);
	}

}
