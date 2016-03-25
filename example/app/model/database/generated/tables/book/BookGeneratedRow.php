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
 * @property-read BookTaggingSelection $relatedTaggings
 * @property-read BookTaggingSelection $taggings
 */
class BookGeneratedRow extends BaseRow
{

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->activeRow->id;
	}


	/**
	 * @return int
	 */
	public function getActive()
	{
		return $this->activeRow->active;
	}


	/**
	 * @return int
	 */
	public function getDeleted()
	{
		return $this->activeRow->deleted;
	}


	/**
	 * @return int
	 */
	public function getAuthorId()
	{
		return $this->activeRow->author_id;
	}


	/**
	 * @return int
	 */
	public function getTranslatorId()
	{
		return $this->activeRow->translator_id;
	}


	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->activeRow->title;
	}


	/**
	 * @return string
	 */
	public function getWeb()
	{
		return $this->activeRow->web;
	}


	/**
	 * @return \Nette\Utils\DateTime
	 */
	public function getCreatedAt()
	{
		return $this->activeRow->createdAt;
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
	 * @return BookTaggingSelection
	 */
	public function getRelatedTaggings()
	{
		return $this->related('book_tagging', 'book_id');
	}


	/**
	 * @return BookTaggingSelection
	 */
	public function getTaggings()
	{
		return $this->related('book_tagging', 'book_id');
	}

}
