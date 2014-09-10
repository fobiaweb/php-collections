<?php
/**
 * This file contains TypedList class.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Fobia\Collections;

/**
 * Представляет собой список, элементы которого состоят из определенного типа.
 *
 * @package Fobia.Collections
 */
class TypedList extends ItemList
{
	private $_type;

	/**
	 * Конструктор.
     *
	 * @param string $type class type
	 */
	public function __construct($type)
	{
		$this->_type=$type;
	}

	/**
     * Вставляет элемент в указанноую позицию.
     * Этот метод перекрывает реализацию родитель, для проверки определенного типа.
     *
	 * @param int   $index   position
	 * @param mixed $item    new item
	 * @throws \Exception Если указанный индекс превышает предел, список доступен только для чтения или элемент не ожидаемого типа.
	 */
	public function insertAt($index, $item)
	{
		if ($item instanceof $this->_type) {
			parent::insertAt($index,$item);
		}
		else {
			throw new \Exception("TypedList<{$type}> can only hold objects of {$type} class.");
		}
	}
}
