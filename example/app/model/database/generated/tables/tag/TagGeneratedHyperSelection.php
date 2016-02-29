<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method TagHyperRow|FALSE fetch()
 * @method TagHyperRow|FALSE get($key)
 * @method TagHyperRow|FALSE current()
 */
class TagGeneratedHyperSelection extends BaseHyperSelection
{

	/**
	 * @param int $value
	 * @return self
	 */
	public function whereId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param string $value
	 * @return self
	 */
	public function whereName($value)
	{
		return $this->where('name', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function withId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param string $value
	 * @return self
	 */
	public function withName($value)
	{
		return $this->where('name', $value);
	}

}
