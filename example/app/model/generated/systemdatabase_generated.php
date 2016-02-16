<?php

namespace Filsedla\Hyperrow;

class SystemDatabase extends \Filsedla\Hyperrow\Database
{

	/**
	 * @return \Filsedla\Hyperrow\SelectionWrapper
	 */
	public function tableAuthor()
	{
		return $this->table('author');
	}


	/**
	 * @return \Filsedla\Hyperrow\SelectionWrapper
	 */
	public function tableBook()
	{
		return $this->table('book');
	}


	/**
	 * @return \Filsedla\Hyperrow\SelectionWrapper
	 */
	public function tableBook_tag()
	{
		return $this->table('book_tag');
	}


	/**
	 * @return \Filsedla\Hyperrow\SelectionWrapper
	 */
	public function tableEmpty()
	{
		return $this->table('empty');
	}


	/**
	 * @return \Filsedla\Hyperrow\SelectionWrapper
	 */
	public function tableTag()
	{
		return $this->table('tag');
	}

}
