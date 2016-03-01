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
 */
class AuthorGeneratedRow extends BaseRow
{

	/**
	 * @return BookSelection
	 */
	public function relatedBooksAsAuthor()
	{
		return $this->related('book', 'author_id');
	}


	/**
	 * @return BookSelection
	 */
	public function relatedBooksAsTranslator()
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


	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @return string
	 */
	public function getWeb()
	{
		return $this->web;
	}


	/**
	 * @return int
	 */
	public function getBorn()
	{
		return $this->born;
	}

}
