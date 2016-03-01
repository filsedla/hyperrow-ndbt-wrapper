<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read int $id
 * @property-read string $name
 */
class TagGeneratedRow extends BaseRow
{

	/**
	 * @return BookTagSelection
	 */
	public function relatedBookTags()
	{
		return $this->related('book_tag', 'tag_id');
	}


	/**
	 * @return BookTagSelection
	 */
	public function getBookTags()
	{
		return $this->related('book_tag', 'tag_id');
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

}
