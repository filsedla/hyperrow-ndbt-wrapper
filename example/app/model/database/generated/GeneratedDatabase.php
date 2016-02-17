<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

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

}
