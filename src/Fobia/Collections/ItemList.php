<?php
/**
 * ItemList class  - ItemList.php file
 *
 * @author     Dmitriy Tyurin <fobia3d@gmail.com>
 * @copyright  Copyright (c) 2014 Dmitriy Tyurin
 *
 * The MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Fobia\Collections;

/**
 * ItemList class
 *
 * @package Fobia.Collections
 */
class ItemList implements \IteratorAggregate, \Countable
{

    private $_d = array();
    private $_c = 0;

    /**
     * Конструктор.
     *
     * Инициализирует список с массива или итерацию объекта.
     *
     * @param array $data the initial data. Default is null, meaning no initialization.
     * @throws \Exception Если данные ни массивом, ни итератор.
     */
    public function __construct(array $data = array())
    {
        $this->copyFrom($data);
    }

    /**
     * Возвращает итератор для обхода элементов в списке.
     * Этот метод требуется интерфейсом IteratorAggregate.
     *
     * @return Iterator an iterator for traversing the items in the list.
     */
    public function getIterator()
    {
        return new ListIterator($this->_d);
    }

    /**
     * Возвращает количество элементов в списке.
     * Этот метод требует Countable интерфейса.
     *
     * @return integer number of items in the list.
     */
    public function count()
    {
        return $this->getCount();
    }

    /**
     * Возвращает количество элементов в списке.
     *
     * @return integer the number of items in the list
     */
    public function getCount()
    {
        return $this->_c;
    }

    /**
     * Возвращает элемент с указанным смещением.
     *
     * @param integer $index the index of the item
     * @return mixed the item at the index
     * @throws \Exception if the index is out of the range
     */
    public function itemAt($index)
    {
        if (isset($this->_d[$index])) {
            return $this->_d[$index];
        } else {
            throw new \Exception("Индекс списка \"{$index}\" вне границы.");
        }
    }

    /**
     * Добавляет элемент в конец списка.
     * @param mixed $item new item
     * @return integer the zero-based index at which the item is added
     */
    public function add($item)
    {
        $this->insertAt($this->_c, $item);
        return $this->_c - 1;
    }

    /**
     * Вставляет элемент в указанной позиции.
     * Оригинальный элемент в позиции и в ближайшие предметы будут перемещены на один шаг ближе к концу.
     *
     * @param integer $index индекс указанной позиции.
     * @param mixed   $item  new item
     * @throws \Exception Если указанный индекс превышает границу
     */
    public function insertAt($index, $item)
    {
        if ($index === $this->_c) {
            $this->_d[$this->_c ++] = $item;
        } elseif ($index >= 0 && $index < $this->_c) {
            array_splice($this->_d, $index, 0, array($item));
            $this->_c ++;
        } else {
            throw new \Exception("Индекс списка \"{$index}\" вне границы.");
        }
    }

    /**
     * Удаляет элемент из списка.
     * Список будет искать сначала пункта.
     * Первый пункт найденого будут удален из списка.
     *
     * @param  mixed $item the item to be removed.
     * @return integer значение индекса на уровне которой элемент будет удален.
     * @throws \Exception Если элемент не существует
     */
    public function remove($item)
    {
        if (($index = $this->indexOf($item)) >= 0) {
            $this->removeAt($index);
            return $index;
        } else {
            return false;
        }
    }

    /**
     * Удаляет элемент в указанной позиции.
     *
     * @param integer $index the index of the item to be removed.
     * @return mixed снятую деталь.
     * @throws \Exception Если указанный индекс превышает границу
     */
    public function removeAt($index)
    {
        if ($index >= 0 && $index < $this->_c) {
            $this->_c --;
            if ($index === $this->_c) {
                return array_pop($this->_d);
            } else {
                $item = $this->_d[$index];
                array_splice($this->_d, $index, 1);
                return $item;
            }
        } else {
            throw new \Exception("Индекс списка \"{$index}\" вне границы.");
        }
    }

    /**
     * Удаляет все элементы в списке.
     *
     * @return void
     */
    public function clear()
    {
        $this->_d = array();
        $this->_c = 0;

        //for ($i = $this->_c - 1; $i >= 0; -- $i) {
        //    $this->removeAt($i);
        //}
    }

    /**
     * @param mixed $item the item
     * @return boolean whether the list contains the item
     */
    public function contains($item)
    {
        return $this->indexOf($item) >= 0;
    }

    /**
     * @param mixed $item the item
     * @return integer the index of the item in the list (0 based), -1 if not found.
     */
    public function indexOf($item, $strict = true)
    {
        if (($index = array_search($item, $this->_d, $strict)) !== false) {
            return $index;
        } else {
            return -1;
        }
    }

    /**
     * @return array the list of items in array
     */
    public function toArray()
    {
        return $this->_d;
    }

    /**
     * Копии Iterable данные в список.
     *
     * Примечание, существующие данные в списке будут удалены в первую очередь.
     *
     * @param mixed $data the data to be copied from, must be an array or object implementing Traversable
     * @throws \Exception Если данные не является ни массивом, ни Traversable.
     */
    public function copyFrom($data)
    {
        if (is_array($data) || ($data instanceof \Traversable)) {
            if ($this->_c > 0) {
                $this->clear();
            }
            foreach ($data as $item) {
                $this->add($item);
            }
        } elseif ($data !== null) {
            throw new \Exception("Список данных должен быть массивом или объектом, реализующим Traversable.");
        }
    }

    /**
     * Объединяет Iterable данные в карте.
     * Новые данные будут добавлены в конец существующих данных.
     *
     * @param mixed $data the data to be merged with, must be an array or object implementing Traversable
     * @throws \Exception Если данные не является ни массивом, ни итератор.
     */
    public function mergeWith($data)
    {
        if (is_array($data) || ($data instanceof \Traversable)) {
            foreach ($data as $item) {
                $this->add($item);
            }
        } elseif ($data !== null) {
            throw new \Exception("Список данных должен быть массивом или объектом, реализующим Traversable.");
        }
    }
}