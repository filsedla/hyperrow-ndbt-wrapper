<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read int $book_id
 * @property-read int $bookId
 * @property-read int $tag_id
 * @property-read int $tagId
 */
class BookTagGeneratedRow extends BaseRow
{

	/**
	 * @return TagRow
	 */
	public function referencedTag()
	{
		return $this->ref('tag', 'tag_id');
	}


	/**
	 * @return BookRow
	 */
	public function referencedBook()
	{
		return $this->ref('book', 'book_id');
	}


	/**
	 * @return TagRow
	 */
	public function getTag()
	{
		return $this->ref('tag', 'tag_id');
	}


	/**
	 * @return BookRow
	 */
	public function getBook()
	{
		return $this->ref('book', 'book_id');
	}


	/**
	 * @return int
	 */
	public function getBookId()
	{
		return $this->book_id;
	}


	/**
	 * @return int
	 */
	public function getTagId()
	{
		return $this->tag_id;
	}

}
