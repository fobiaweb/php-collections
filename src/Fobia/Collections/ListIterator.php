<?php
/**
 * ListIterator class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * 
 * Модификацияя класса ListIterator фраемфорка yiif
 * 
 * @author Dmitriy Tyurin <fobia3d@gmail.com>
 */

namespace Fobia\Collections;

/**
 * Реализует итератор для {@link \Fobia\Collections\ItemList}.
 * Избегает повторных копий обходного масива за счет передачи по сылки.
 *
 * Это позволяет ItemList вернуть новый итератор для обхода элементов в списке.
 *
 * @package Fobia.Collections
 */
class ListIterator implements \Iterator
{

    /**
     * @var array the data to be iterated through
     */
    private $_d;

    /**
     * @var integer index of the current item
     */
    private $_i;

    /**
     * @var integer count of the data items
     */
    private $_c;

    /**
     * Constructor.
     *
     * @param array $data the data to be iterated through
     */
    public function __construct(&$data)
    {
        $this->_d = &$data;
        $this->_i = 0;
        $this->_c = count($this->_d);
    }

    /**
     * Rewinds internal array pointer.
     * This method is required by the interface Iterator.
     */
    public function rewind()
    {
        $this->_i = 0;
    }

    /**
     * Returns the key of the current array item.
     * This method is required by the interface Iterator.
     *
     * @return integer the key of the current array item
     */
    public function key()
    {
        return $this->_i;
    }

    /**
     * Returns the current array item.
     * This method is required by the interface Iterator.
     *
     * @return mixed the current array item
     */
    public function current()
    {
        return $this->_d[$this->_i];
    }

    /**
     * Moves the internal pointer to the next array item.
     * This method is required by the interface Iterator.
     */
    public function next()
    {
        $this->_i ++;
    }

    /**
     * Returns whether there is an item at current position.
     * This method is required by the interface Iterator.
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->_i < $this->_c;
    }
}