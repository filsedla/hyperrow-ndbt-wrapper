<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method BookRow|FALSE fetch()
 * @method BookRow|FALSE get($key)
 * @method BookRow|FALSE current()
 */
class BookGeneratedSelection extends BaseSelection
{

	/**
	 * @param int $value
	 * @return self
	 */
	public function whereId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function whereActive($value)
	{
		return $this->where('active', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function whereDeleted($value)
	{
		return $this->where('deleted', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function whereAuthorId($value)
	{
		return $this->where('author_id', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function whereTranslatorId($value)
	{
		return $this->where('translator_id', $value);
	}


	/**
	 * @param string $value
	 * @return self
	 */
	public function whereTitle($value)
	{
		return $this->where('title', $value);
	}


	/**
	 * @param string $value
	 * @return self
	 */
	public function whereWeb($value)
	{
		return $this->where('web', $value);
	}


	/**
	 * @return self
	 */
	public function whereFutureCreatedAt()
	{
		return $this->where('createdAt > NOW()');
	}


	/**
	 * @return self
	 */
	public function wherePastCreatedAt()
	{
		return $this->where('createdAt < NOW()');
	}


	/**
	 * @param \Nette\Utils\DateTime $value
	 * @return self
	 */
	public function whereCreatedAt($value)
	{
		return $this->where('createdAt', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function withId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function withActive($value)
	{
		return $this->where('active', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function withDeleted($value)
	{
		return $this->where('deleted', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function withAuthorId($value)
	{
		return $this->where('author_id', $value);
	}


	/**
	 * @param int $value
	 * @return self
	 */
	public function withTranslatorId($value)
	{
		return $this->where('translator_id', $value);
	}


	/**
	 * @param string $value
	 * @return self
	 */
	public function withTitle($value)
	{
		return $this->where('title', $value);
	}


	/**
	 * @param string $value
	 * @return self
	 */
	public function withWeb($value)
	{
		return $this->where('web', $value);
	}


	/**
	 * @return self
	 */
	public function withFutureCreatedAt()
	{
		return $this->where('createdAt > NOW()');
	}


	/**
	 * @return self
	 */
	public function withPastCreatedAt()
	{
		return $this->where('createdAt < NOW()');
	}


	/**
	 * @param \Nette\Utils\DateTime $value
	 * @return self
	 */
	public function withCreatedAt($value)
	{
		return $this->where('createdAt', $value);
	}

}
