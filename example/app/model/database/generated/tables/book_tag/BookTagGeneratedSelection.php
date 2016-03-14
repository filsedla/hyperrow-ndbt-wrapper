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
 * @method BookTagRow insert($data)
 * @method BookTagRow[] fetchAll()
 * @method BookTagSelection order($columns)
 * @method BookTagSelection limit($limit, $offset = NULL)
 * @method BookTagSelection page($page, $itemsPerPage, & $numOfPages = NULL)
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
