<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read int $book_id
 * @property-read int $tag_id
 */
class BookTagGeneratedHyperRow extends BaseHyperRow
{

	/**
	 * @return TagHyperRow
	 */
	public function referencedTag()
	{
		return $this->ref('tag', 'tag_id');
	}


	/**
	 * @return BookHyperRow
	 */
	public function referencedBook()
	{
		return $this->ref('book', 'book_id');
	}

}
