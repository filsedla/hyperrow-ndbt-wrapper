<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read int $id
 * @property-read int $author_id
 * @property-read int $translator_id
 * @property-read string $title
 * @property-read string $web
 */
class BookGeneratedHyperRow extends BaseHyperRow
{

	/**
	 * @return AuthorHyperRow
	 */
	public function getAuthor()
	{
		return $this->ref('author', 'author_id');
	}


	/**
	 * @return AuthorHyperRow
	 */
	public function getTranslator()
	{
		return $this->ref('author', 'translator_id');
	}


	/**
	 * @return BookTagHyperSelection
	 */
	public function relatedTags()
	{
		return $this->related('book_tag', 'book_id');
	}

}
