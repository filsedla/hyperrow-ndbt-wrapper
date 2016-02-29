<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @property-read int $id
 * @property-read string $name
 */
class TagGeneratedHyperRow extends BaseHyperRow
{

	/**
	 * @return BookTagHyperSelection
	 */
	public function relatedBookTags()
	{
		return $this->related('book_tag', 'tag_id');
	}


	/**
	 * @return BookTagHyperSelection
	 */
	public function getBookTags()
	{
		return $this->related('book_tag', 'tag_id');
	}

}
