<?php

namespace Filsedla\Hyperrow;

class SystemDatabase extends \Filsedla\Hyperrow\BaseDatabase
{

	/**
	 * @return \Filsedla\Hyperrow\BaseHyperSelection
	 */
	public function tableAuthor()
	{
		return $this->table('author');
	}


	/**
	 * @return \Filsedla\Hyperrow\BaseHyperSelection
	 */
	public function tableBook()
	{
		return $this->table('book');
	}


	/**
	 * @return \Filsedla\Hyperrow\BaseHyperSelection
	 */
	public function tableBook_tag()
	{
		return $this->table('book_tag');
	}


	/**
	 * @return \Filsedla\Hyperrow\BaseHyperSelection
	 */
	public function tableEmpty()
	{
		return $this->table('empty');
	}


	/**
	 * @return \Filsedla\Hyperrow\BaseHyperSelection
	 */
	public function tableTag()
	{
		return $this->table('tag');
	}

}
