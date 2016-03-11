<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method BookTagRow|FALSE fetch()
 * @method BookTagRow|FALSE get($key)
 * @method BookTagRow|FALSE current()
 * @method BookTagSelection where($condition, $parameters = [])
 */
class BookTagGeneratedSelection extends BaseSelection
{

	/**
	 * @param int $value
	 * @return BookTagSelection
	 */
	public function whereBookId($value)
	{
		return $this->where('book_id', $value);
	}


	/**
	 * @param int $value
	 * @return BookTagSelection
	 */
	public function whereTagId($value)
	{
		return $this->where('tag_id', $value);
	}


	/**
	 * @param int $value
	 * @return BookTagSelection
	 */
	public function withBookId($value)
	{
		return $this->where('book_id', $value);
	}


	/**
	 * @param int $value
	 * @return BookTagSelection
	 */
	public function withTagId($value)
	{
		return $this->where('tag_id', $value);
	}

}
