<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read int $id
 * @property-read int $active
 * @property-read int $deleted
 * @property-read int $author_id
 * @property-read int $translator_id
 * @property-read string $title
 * @property-read string $web
 * @property-read \Nette\Utils\DateTime $createdAt
 * @property-read int $authorId
 * @property-read int $translatorId
 * @property-read AuthorRow $author
 * @property-read AuthorRow $translator
 * @property-read BookTagSelection $relatedTags
 * @property-read BookTagSelection $tags
 */
class BookGeneratedRow extends BaseRow
{

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * @return int
	 */
	public function getActive()
	{
		return $this->active;
	}


	/**
	 * @return int
	 */
	public function getDeleted()
	{
		return $this->deleted;
	}


	/**
	 * @return int
	 */
	public function getAuthorId()
	{
		return $this->author_id;
	}


	/**
	 * @return int
	 */
	public function getTranslatorId()
	{
		return $this->translator_id;
	}


	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}


	/**
	 * @return string
	 */
	public function getWeb()
	{
		return $this->web;
	}


	/**
	 * @return \Nette\Utils\DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}


	/**
	 * @return AuthorRow
	 */
	public function referencedAuthor()
	{
		return $this->ref('author', 'author_id');
	}


	/**
	 * @return AuthorRow
	 */
	public function referencedTranslator()
	{
		return $this->ref('author', 'translator_id');
	}


	/**
	 * @return AuthorRow
	 */
	public function getAuthor()
	{
		return $this->ref('author', 'author_id');
	}


	/**
	 * @return AuthorRow
	 */
	public function getTranslator()
	{
		return $this->ref('author', 'translator_id');
	}


	/**
	 * @return BookTagSelection
	 */
	public function getRelatedTags()
	{
		return $this->related('book_tag', 'book_id');
	}


	/**
	 * @return BookTagSelection
	 */
	public function getTags()
	{
		return $this->related('book_tag', 'book_id');
	}

}
