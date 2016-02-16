<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Generated;

/**
 * @property-read int $id
 * @property-read string $name
 */
class TagBaseHyperRow extends HyperRow
{

	/**
	 * @return BookTagHyperSelection
	 */
	public function relatedBookTags()
	{
		return $this->related('book_tag', 'tag_id');
	}

}
