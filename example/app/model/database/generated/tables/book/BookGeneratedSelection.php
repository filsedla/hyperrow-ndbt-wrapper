<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method BookRow|FALSE fetch()
 * @method BookRow|FALSE get($key)
 * @method BookRow|FALSE current()
 * @method BookSelection select($columns)
 * @method BookSelection where($condition, $parameters = [])
 * @method BookRow insert($data)
 * @method BookRow[] fetchAll()
 * @method BookSelection order($columns)
 * @method BookSelection limit($limit, $offset = NULL)
 * @method BookSelection page($page, $itemsPerPage, & $numOfPages = NULL)
 */
class BookGeneratedSelection extends BaseSelection
{

	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function whereId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function whereActive($value)
	{
		return $this->where('active', $value);
	}


	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function whereDeleted($value)
	{
		return $this->where('deleted', $value);
	}


	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function whereAuthorId($value)
	{
		return $this->where('author_id', $value);
	}


	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function whereTranslatorId($value)
	{
		return $this->where('translator_id', $value);
	}


	/**
	 * @param string $value
	 * @return BookSelection
	 */
	public function whereTitle($value)
	{
		return $this->where('title', $value);
	}


	/**
	 * @param string $value
	 * @return BookSelection
	 */
	public function whereWeb($value)
	{
		return $this->where('web', $value);
	}


	/**
	 * @return BookSelection
	 */
	public function whereFutureCreatedAt()
	{
		return $this->where('createdAt > NOW()');
	}


	/**
	 * @return BookSelection
	 */
	public function wherePastCreatedAt()
	{
		return $this->where('createdAt < NOW()');
	}


	/**
	 * @param \Nette\Utils\DateTime $value
	 * @return BookSelection
	 */
	public function whereCreatedAt($value)
	{
		return $this->where('createdAt', $value);
	}


	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function withId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function withActive($value)
	{
		return $this->where('active', $value);
	}


	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function withDeleted($value)
	{
		return $this->where('deleted', $value);
	}


	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function withAuthorId($value)
	{
		return $this->where('author_id', $value);
	}


	/**
	 * @param int $value
	 * @return BookSelection
	 */
	public function withTranslatorId($value)
	{
		return $this->where('translator_id', $value);
	}


	/**
	 * @param string $value
	 * @return BookSelection
	 */
	public function withTitle($value)
	{
		return $this->where('title', $value);
	}


	/**
	 * @param string $value
	 * @return BookSelection
	 */
	public function withWeb($value)
	{
		return $this->where('web', $value);
	}


	/**
	 * @return BookSelection
	 */
	public function withFutureCreatedAt()
	{
		return $this->where('createdAt > NOW()');
	}


	/**
	 * @return BookSelection
	 */
	public function withPastCreatedAt()
	{
		return $this->where('createdAt < NOW()');
	}


	/**
	 * @param \Nette\Utils\DateTime $value
	 * @return BookSelection
	 */
	public function withCreatedAt($value)
	{
		return $this->where('createdAt', $value);
	}


	/**
	 * @return BookSelection
	 */
	public function withTagging($bookTaggingId)
	{
		return $this->where(':book_tagging(book_id).id', $bookTaggingId);
	}


	/**
	 * @return BookSelection
	 */
	public function withTaggingWithTag($tagId)
	{
		return $this->where(':book_tagging(book_id).tag_id', $tagId);
	}

}
