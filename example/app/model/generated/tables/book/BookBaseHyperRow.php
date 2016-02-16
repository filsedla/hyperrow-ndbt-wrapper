<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Generated;

/**
 * @property-read int $id
 * @property-read int $author_id
 * @property-read int $translator_id
 * @property-read string $title
 * @property-read string $web
 */
class BookBaseHyperRow extends HyperRow
{

	/**
	 * @return AuthorHyperRow
	 */
	public function referencedAuthor()
	{
		return $this->ref('author', 'translator_id');
	}


	/**
	 * @return BookTagHyperSelection
	 */
	public function relatedBookTags()
	{
		return $this->related('book_tag', 'book_id');
	}

}
