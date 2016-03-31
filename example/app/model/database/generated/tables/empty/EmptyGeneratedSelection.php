<?php

/**
 * This is a generated file. DO NOT EDIT. It will be overwritten.
 */

namespace Example\Model\Database;

/**
 * @method EmptyRow|FALSE fetch()
 * @method EmptyRow|FALSE get($key)
 * @method EmptyRow|FALSE current()
 * @method EmptySelection select($columns)
 * @method EmptySelection where($condition, $parameters = [])
 * @method EmptySelection wherePrimary($key)
 * @method EmptySelection group($columns)
 * @method EmptySelection having($having)
 * @method EmptyRow insert($data)
 * @method EmptyRow[] fetchAll()
 * @method EmptySelection order($columns)
 * @method EmptySelection limit($limit, $offset = NULL)
 * @method EmptySelection page($page, $itemsPerPage, & $numOfPages = NULL)
 */
class EmptyGeneratedSelection extends BaseSelection
{

	/**
	 * @param int $value
	 * @return EmptySelection
	 */
	public function whereId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param string $value
	 * @return EmptySelection
	 */
	public function whereName($value)
	{
		return $this->where('name', $value);
	}


	/**
	 * @param int $value
	 * @return EmptySelection
	 */
	public function withId($value)
	{
		return $this->where('id', $value);
	}


	/**
	 * @param string $value
	 * @return EmptySelection
	 */
	public function withName($value)
	{
		return $this->where('name', $value);
	}

}
