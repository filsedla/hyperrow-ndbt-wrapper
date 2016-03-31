<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method AuthorRow|FALSE fetch()
 * @method AuthorRow|FALSE get($key)
 * @method AuthorRow|FALSE current()
 * @method AuthorSelection select($columns)
 * @method AuthorSelection where($condition, $parameters = [])
 * @method AuthorSelection wherePrimary($key)
 * @method AuthorSelection group($columns)
 * @method AuthorSelection having($having)
 * @method AuthorRow insert($data)
 * @method AuthorRow[] fetchAll()
 * @method AuthorSelection order($columns)
 * @method AuthorSelection limit($limit, $offset = NULL)
 * @method AuthorSelection page($page, $itemsPerPage, & $numOfPages = NULL)
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


	/**
	 * @return AuthorSelection
	 */
	public function withBookAsAuthor($bookId)
	{
		return $this->where(':book(author_id).id', $bookId);
	}


	/**
	 * @return AuthorSelection
	 */
	public function withBookAsTranslator($bookId)
	{
		return $this->where(':book(translator_id).id', $bookId);
	}


	/**
	 * @return AuthorSelection
	 */
	public function withBookAsAuthorWithTranslator($translatorId)
	{
		return $this->where(':book(author_id).translator_id', $translatorId);
	}


	/**
	 * @return AuthorSelection
	 */
	public function withBookAsTranslatorWithAuthor($authorId)
	{
		return $this->where(':book(translator_id).author_id', $authorId);
	}

}
