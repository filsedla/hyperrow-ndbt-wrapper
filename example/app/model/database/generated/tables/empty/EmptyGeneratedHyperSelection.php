<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method EmptyHyperRow|FALSE fetch()
 * @method EmptyHyperRow|FALSE get($key)
 * @method EmptyHyperRow|FALSE current()
 */
class EmptyGeneratedHyperSelection extends BaseHyperSelection
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
