<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method BookTagRow|FALSE fetch()
 * @method BookTagRow|FALSE get($key)
 * @method BookTagRow|FALSE current()
 */
class BookTagGeneratedSelection extends BaseSelection
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
