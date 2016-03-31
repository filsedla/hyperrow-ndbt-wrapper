<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method BookTaggingRow|FALSE fetch()
 * @method BookTaggingRow|FALSE get($key)
 * @method BookTaggingRow|FALSE current()
 * @method BookTaggingSelection select($columns)
 * @method BookTaggingSelection where($condition, $parameters = [])
 * @method BookTaggingSelection wherePrimary($key)
 * @method BookTaggingRow insert($data)
 * @method BookTaggingRow[] fetchAll()
 * @method BookTaggingSelection order($columns)
 * @method BookTaggingSelection limit($limit, $offset = NULL)
 * @method BookTaggingSelection page($page, $itemsPerPage, & $numOfPages = NULL)
 */
class BookTaggingGeneratedSelection extends BaseSelection
{

	/**
	 * @param int $value
	 * @return BookTaggingSelection
	 */
	public function whereBookId($value)
	{
		return $this->where('book_id', $value);
	}


	/**
	 * @param int $value
	 * @return BookTaggingSelection
	 */
	public function whereTagId($value)
	{
		return $this->where('tag_id', $value);
	}


	/**
	 * @param int $value
	 * @return BookTaggingSelection
	 */
	public function withBookId($value)
	{
		return $this->where('book_id', $value);
	}


	/**
	 * @param int $value
	 * @return BookTaggingSelection
	 */
	public function withTagId($value)
	{
		return $this->where('tag_id', $value);
	}

}
