<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read BookTaggingSelection $relatedBookTaggings
 * @property-read BookTaggingSelection $bookTaggings
 */
class TagGeneratedRow extends BaseRow
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
	 * @return BookTaggingSelection
	 */
	public function getRelatedBookTaggings()
	{
		return $this->related('book_tagging', 'tag_id');
	}


	/**
	 * @return BookTaggingSelection
	 */
	public function getBookTaggings()
	{
		return $this->related('book_tagging', 'tag_id');
	}

}
