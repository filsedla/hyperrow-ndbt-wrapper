<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $web
 * @property-read int $born
 * @property-read BookSelection $relatedBooksAsAuthor
 * @property-read BookSelection $relatedBooksAsTranslator
 * @property-read BookSelection $booksAsAuthor
 * @property-read BookSelection $booksAsTranslator
 */
class AuthorGeneratedRow extends BaseRow
{

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->activeRow->id;
	}


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->activeRow->name;
	}


	/**
	 * @return string
	 */
	public function getWeb()
	{
		return $this->activeRow->web;
	}


	/**
	 * @return int
	 */
	public function getBorn()
	{
		return $this->activeRow->born;
	}


	/**
	 * @return BookSelection
	 */
	public function getRelatedBooksAsAuthor()
	{
		return $this->related('book', 'author_id');
	}


	/**
	 * @return BookSelection
	 */
	public function getRelatedBooksAsTranslator()
	{
		return $this->related('book', 'translator_id');
	}


	/**
	 * @return BookSelection
	 */
	public function getBooksAsAuthor()
	{
		return $this->related('book', 'author_id');
	}


	/**
	 * @return BookSelection
	 */
	public function getBooksAsTranslator()
	{
		return $this->related('book', 'translator_id');
	}

}
