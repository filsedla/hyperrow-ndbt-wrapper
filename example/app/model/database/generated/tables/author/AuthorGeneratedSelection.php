<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method AuthorRow|FALSE fetch()
 * @method AuthorRow|FALSE get($key)
 * @method AuthorRow|FALSE current()
 * @method AuthorSelection where($condition, $parameters = [])
 */
class AuthorGeneratedSelection extends BaseSelection
{

	/**
	 * @param int $value
	 * @return AuthorSelection
	 */
	public function whereId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param string $value
	 * @return AuthorSelection
	 */
	public function whereName($value)
	{
		return $this->where('name', $value);
	}


	/**
	 * @param string $value
	 * @return AuthorSelection
	 */
	public function whereWeb($value)
	{
		return $this->where('web', $value);
	}


	/**
	 * @param int $value
	 * @return AuthorSelection
	 */
	public function whereBorn($value)
	{
		return $this->where('born', $value);
	}


	/**
	 * @param int $value
	 * @return AuthorSelection
	 */
	public function withId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param string $value
	 * @return AuthorSelection
	 */
	public function withName($value)
	{
		return $this->where('name', $value);
	}


	/**
	 * @param string $value
	 * @return AuthorSelection
	 */
	public function withWeb($value)
	{
		return $this->where('web', $value);
	}


	/**
	 * @param int $value
	 * @return AuthorSelection
	 */
	public function withBorn($value)
	{
		return $this->where('born', $value);
	}

}
