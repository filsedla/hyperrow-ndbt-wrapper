<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read AuthorHyperSelection $author
 * @property-read BookHyperSelection $book
 * @property-read BookTagHyperSelection $bookTag
 * @property-read EmptyHyperSelection $empty
 * @property-read TagHyperSelection $tag
 */
class GeneratedDatabase extends \Filsedla\Hyperrow\Database
{

	/**
	 * @return AuthorHyperSelection
	 */
	public function tableAuthor()
	{
		return $this->table('author');
	}


	/**
	 * @return BookHyperSelection
	 */
	public function tableBook()
	{
		return $this->table('book');
	}


	/**
	 * @return BookTagHyperSelection
	 */
	public function tableBookTag()
	{
		return $this->table('book_tag');
	}


	/**
	 * @return EmptyHyperSelection
	 */
	public function tableEmpty()
	{
		return $this->table('empty');
	}


	/**
	 * @return TagHyperSelection
	 */
	public function tableTag()
	{
		return $this->table('tag');
	}


	/**
	 * @return AuthorHyperSelection
	 */
	public function getAuthor()
	{
		return $this->table('author');
	}


	/**
	 * @return BookHyperSelection
	 */
	public function getBook()
	{
		return $this->table('book');
	}


	/**
	 * @return BookTagHyperSelection
	 */
	public function getBookTag()
	{
		return $this->table('book_tag');
	}


	/**
	 * @return EmptyHyperSelection
	 */
	public function getEmpty()
	{
		return $this->table('empty');
	}


	/**
	 * @return TagHyperSelection
	 */
	public function getTag()
	{
		return $this->table('tag');
	}

}
