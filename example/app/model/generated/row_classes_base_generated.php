<?php

namespace Filsedla\Hyperrow;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $web
 * @property-read int $born
 */
class author_BaseRowClass extends \Filsedla\Hyperrow\BaseHyperRow
{

	/**
	 * @return \Filsedla\Hyperrow\BaseHyperSelection
	 */
	public function relatedBooksAsAuthor()
	{
		return $this->related('book', 'author_id');
	}


	/**
	 * @return \Filsedla\Hyperrow\BaseHyperSelection
	 */
	public function relatedBooksAsTranslator()
	{
		return $this->related('book', 'translator_id');
	}

}


/**
 * @property-read int $id
 * @property-read int $author_id
 * @property-read int $translator_id
 * @property-read string $title
 * @property-read string $web
 */
class book_BaseRowClass extends \Filsedla\Hyperrow\BaseHyperRow
{

	/**
	 * @return \Filsedla\Hyperrow\Model\Author
	 */
	public function referencedAuthor()
	{
		return $this->ref('author', 'translator_id');
	}


	/**
	 * @return \Filsedla\Hyperrow\BaseHyperSelection
	 */
	public function relatedBook_tags()
	{
		return $this->related('book_tag', 'book_id');
	}

}


/**
 * @property-read int $book_id
 * @property-read int $tag_id
 */
class book_tag_BaseRowClass extends \Filsedla\Hyperrow\BaseHyperRow
{

	/**
	 * @return \Filsedla\Hyperrow\Model\Tag
	 */
	public function referencedTag()
	{
		return $this->ref('tag', 'tag_id');
	}


	/**
	 * @return \Filsedla\Hyperrow\Model\Book
	 */
	public function referencedBook()
	{
		return $this->ref('book', 'book_id');
	}

}


/**
 * @property-read int $id
 * @property-read string $name
 */
class empty_BaseRowClass extends \Filsedla\Hyperrow\BaseHyperRow
{
}


/**
 * @property-read int $id
 * @property-read string $name
 */
class tag_BaseRowClass extends \Filsedla\Hyperrow\BaseHyperRow
{

	/**
	 * @return \Filsedla\Hyperrow\BaseHyperSelection
	 */
	public function relatedBook_tags()
	{
		return $this->related('book_tag', 'tag_id');
	}

}
