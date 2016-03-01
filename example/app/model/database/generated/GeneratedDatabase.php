<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read AuthorSelection $author
 * @property-read BookSelection $book
 * @property-read BookTagSelection $bookTag
 * @property-read EmptySelection $empty
 * @property-read TagSelection $tag
 */
class GeneratedDatabase extends \Filsedla\Hyperrow\Database
{

	/**
	 * @return AuthorSelection
	 */
	public function tableAuthor()
	{
		return $this->table('author');
	}


	/**
	 * @return BookSelection
	 */
	public function tableBook()
	{
		return $this->table('book');
	}


	/**
	 * @return BookTagSelection
	 */
	public function tableBookTag()
	{
		return $this->table('book_tag');
	}


	/**
	 * @return EmptySelection
	 */
	public function tableEmpty()
	{
		return $this->table('empty');
	}


	/**
	 * @return TagSelection
	 */
	public function tableTag()
	{
		return $this->table('tag');
	}


	/**
	 * @return AuthorSelection
	 */
	public function getAuthor()
	{
		return $this->table('author');
	}


	/**
	 * @return BookSelection
	 */
	public function getBook()
	{
		return $this->table('book');
	}


	/**
	 * @return BookTagSelection
	 */
	public function getBookTag()
	{
		return $this->table('book_tag');
	}


	/**
	 * @return EmptySelection
	 */
	public function getEmpty()
	{
		return $this->table('empty');
	}


	/**
	 * @return TagSelection
	 */
	public function getTag()
	{
		return $this->table('tag');
	}

}
