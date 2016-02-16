<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Generated;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $web
 * @property-read int $born
 */
class AuthorBaseHyperRow extends HyperRow
{

	/**
	 * @return BookHyperSelection
	 */
	public function relatedBooksAsAuthor()
	{
		return $this->related('book', 'author_id');
	}


	/**
	 * @return BookHyperSelection
	 */
	public function relatedBooksAsTranslator()
	{
		return $this->related('book', 'translator_id');
	}

}
