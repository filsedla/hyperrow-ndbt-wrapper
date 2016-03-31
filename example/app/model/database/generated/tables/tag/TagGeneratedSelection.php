<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method TagRow|FALSE fetch()
 * @method TagRow|FALSE get($key)
 * @method TagRow|FALSE current()
 * @method TagSelection select($columns)
 * @method TagSelection where($condition, $parameters = [])
 * @method TagSelection wherePrimary($key)
 * @method TagSelection group($columns)
 * @method TagSelection having($having)
 * @method TagRow insert($data)
 * @method TagRow[] fetchAll()
 * @method TagSelection order($columns)
 * @method TagSelection limit($limit, $offset = NULL)
 * @method TagSelection page($page, $itemsPerPage, & $numOfPages = NULL)
 * @method TagRow offsetGet($key)
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


	/**
	 * @return TagSelection
	 */
	public function withBookTagging($bookTaggingId)
	{
		return $this->where(':book_tagging(tag_id).id', $bookTaggingId);
	}


	/**
	 * @return TagSelection
	 */
	public function withBookTaggingWithBook($bookId)
	{
		return $this->where(':book_tagging(tag_id).book_id', $bookId);
	}


	/**
	 * @return TagSelection
	 */
	public function taggingBook($bookId)
	{
		return $this->where(':book_tagging(tag_id).book_id', $bookId);
	}

}
