<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method BookTagHyperRow|FALSE fetch()
 * @method BookTagHyperRow|FALSE get($key)
 * @method BookTagHyperRow|FALSE current()
 */
class BookTagGeneratedHyperSelection extends BaseHyperSelection
{

	/**
	 * @param int $value
	 * @return self
	 */
	public function whereBookId($value)
	{
		return $this->where('book_id', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function whereTagId($value)
	{
		return $this->where('tag_id', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function withBookId($value)
	{
		return $this->where('book_id', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function withTagId($value)
	{
		return $this->where('tag_id', $value);
	}

}
