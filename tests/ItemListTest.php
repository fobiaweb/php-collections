<?php

namespace Fobia\Collections\Test;

use Fobia\Collections\ItemList;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-09-08 at 02:10:21.
 */
class ItemListTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ItemList
     */
    protected $object;
   protected $handler_error_level;

    const DEFAULT_COUNT = 10;

    /**
     * Создает список элементов
     * Каждый элемент имеет
     *  id   - порядковый номер
     *  name - имя (на основе id)
     *  type - типо (у всех new)
     *  group - группа элемента (Общее кол. создаваемых элементов деляться на 5 групп)
     *  param1 - каждая группа имеет параметры paramX, кол. которых возрвстают с возрвстанием группы
     *  param2, param3...
     *
     * @param int $count
     * @param bool $create_obj
     * @return array
     */
    public function createArrayItems($count = null, $create_obj = false)
    {
        $groups = 5;
        if ($count === null) {
            $count = self::DEFAULT_COUNT;
        }
        $data = array();
        $group_count = ceil($count / $groups);

        for ($i = 0; $i < $count; $i++ ) {
            $_current_group =  ceil(($i + 1) / $group_count);
            $item = array(
                'id'   => $i,
                'name' => "name_" . $i,
                'type' => 'new',
                'group' => $_current_group,
            );
            for($g = 1; $g < $_current_group; $g++) {
                $item["param$g"] = null;
            }

            if ($create_obj) {
                $item = (object) $item;
            }
            $data[] = $item;
        }

        return $data;
    }

    protected function setErrorHandler($errno_level = 256)
    {
        $this->handler_error_level = error_reporting(0);
        set_error_handler(function($errno) use ($errno_level) {
            if ( ! ($errno & $errno_level)) {
                return;
            }
            throw new \Exception("Error", $errno);
        });
    }

    protected function restoreErrorHandler()
    {
        if ($this->handler_error_level !== null) {
            restore_error_handler();
            error_reporting($this->handler_error_level);
            $this->handler_error_level = null;
        }
    }

    protected function setUp()
    {
        $this->object = new ItemList($this->createArrayItems());
    }

    protected function tearDown()
    {
        $this->restoreErrorHandler();
    }
    ///////////////////////////////////////////////////////////////////////////

    /**
     * @covers Fobia\Collections\ItemList::getIterator
     */
    public function testGetIterator()
    {
        $this->assertInstanceOf('Traversable', $this->object);
        $this->assertInstanceOf('Traversable', $this->object->getIterator());
    }

    /**
     * @covers Fobia\Collections\ItemList::count
     */
    public function testCount()
    {
        $this->assertCount(self::DEFAULT_COUNT, $this->object);
    }

    /**
     * @covers Fobia\Collections\ItemList::getCount
     */
    public function testGetCount()
    {
        $this->assertEquals(10, $this->object->getCount());
    }

    /**
     * @covers Fobia\Collections\ItemList::itemAt
     */
    public function testItemAt()
    {
        $item = $this->object->itemAt(1);

        $this->assertArrayHasKey('id', $item);
        $this->assertArrayHasKey('name', $item);
        $this->assertEquals(1, $item['id']);
        $this->assertEquals('name_1', $item['name']);
    }

    /**
     * @covers Fobia\Collections\ItemList::add
     * @todo   Implement testAdd().
     */
    public function testAdd()
    {
        $index = $this->object->add(array(
            'id' => 10,
            'name' => 'name_10',
            'type' => 'add'
        ));

        $this->assertEquals(self::DEFAULT_COUNT, $index);
    }

    /**
     * @covers Fobia\Collections\ItemList::insertAt
     */
    public function testInsertAt()
    {
        $item = array(
            'id' => 10,
            'name' => 'name_10',
            'type' => 'add'
        );
        $this->object->insertAt(1, $item);

        $this->assertCount(self::DEFAULT_COUNT + 1, $this->object);
        $this->assertSame($item, $this->object->itemAt(1));
    }

    /**
     * @covers Fobia\Collections\ItemList::remove
     * @todo   Implement testRemove().
     */
    public function testRemove()
    {
        $item = array(
            'id' => 10,
            'name' => 'name_10',
            'type' => 'add'
        );
        $this->object->insertAt(1, $item);
        $index = $this->object->remove($item);
        $this->assertEquals(1, $index);
    }

    /**
     * @covers Fobia\Collections\ItemList::removeAt
     * @todo   Implement testRemoveAt().
     */
    public function testRemoveAt()
    {
        $item0 = $this->object->itemAt(0);
        $this->assertEquals('name_0', $item0['name']);

        $item = $this->object->removeAt(0);
        $this->assertCount(self::DEFAULT_COUNT - 1, $this->object);
        $this->assertSame($item0, $item);

        $item = $this->object->itemAt(0);
        $this->assertEquals('name_1', $item['name']);
    }

    /**
     * @covers Fobia\Collections\ItemList::clear
     */
    public function testClear()
    {
        $this->object->clear();
        $this->assertCount(0, $this->object);
    }

    /**
     * @covers Fobia\Collections\ItemList::contains
     * @todo   Implement testContains().
     */
    public function testContains()
    {
        $item = array(
            'id' => 10,
            'name' => 'name_10',
            'type' => 'add'
        );
        $this->assertFalse($this->object->contains($item));
        $this->object->add($item);
        $this->assertTrue($this->object->contains($item));
    }

    /**
     * @covers Fobia\Collections\ItemList::indexOf
     * @todo   Implement testIndexOf().
     */
    public function testIndexOf()
    {
        $item_new = array(
            'id' => 11,
            'name' => 'name_11',
            'type' => 'add'
        );
        $index = $this->object->add($item_new);
        $this->assertSame($index, $this->object->indexOf($item_new));
    }

    /**
     * @covers Fobia\Collections\ItemList::indexOf
     * @todo   Implement testIndexOf().
     */
    public function testIndexOfOrigin()
    {
        $item = $this->object->itemAt(0);
        $index = $this->object->indexOf($item);
        $this->assertEquals(0, $index);
    }
    
    /**
     * @covers Fobia\Collections\ItemList::indexOf
     * @todo   Implement testIndexOf().
     */
    public function testIndexOfOther()
    {
        $item = $this->object->itemAt(0);
        $item_clone = array();
        foreach ($item as $key => $value) {
            $item_clone[$key] = $value;
        }

        $this->assertEquals(0, $this->object->indexOf($item_clone));
    }

    /**
     * @covers Fobia\Collections\ItemList::toArray
     * @todo   Implement testToArray().
     */
    public function testToArray()
    {
        $arr = $this->object->toArray();
        $this->assertInternalType('array', $arr);

        foreach ($this->object as $k => $v) {
            $this->assertSame($arr[$k], $v);
        }
    }

    /**
     * @covers Fobia\Collections\ItemList::copyFrom
     * @todo   Implement testCopyFrom().
     */
    public function testCopyFrom()
    {
        // Remove the following lines when you implement this test.
        $this->assertCount(self::DEFAULT_COUNT, $this->object);

        $data = $this->createArrayItems(5);
        foreach ($data as $k => $v) {
            $data[$k]['type'] = 'test';
        }
        $this->object->copyFrom($data);
        $this->assertCount(5, $this->object);
    }

    /**
     * @covers Fobia\Collections\ItemList::mergeWith
     * @todo   Implement testMergeWith().
     */
    public function testMergeWith()
    {
        $arr = $this->createArrayItems(5);
        $arr[] = array(
            'id' => 22,
            'name' => 'name_22',
            'type' => 'merge'
        );
        $this->object->mergeWith($arr);

        $this->assertCount(self::DEFAULT_COUNT + 5 + 1, $this->object);
        //$this->assertSame($arr, $this->object->itemAt($this->object->getCount() - 1));
    }

    /**
     * @covers Fobia\Collections\ItemList::each
     */
    public function testEachFull()
    {
        $this->object->each(function(&$item, $index) {
            $item['type'] = 'each_' . $index;
        });

        $item = $this->object->itemAt(0);
        $this->assertEquals('each_0', $item['type']);

        $lastIndex = $this->object->count() - 1;
        $item = $this->object->itemAt($lastIndex);
        $this->assertEquals('each_' . $lastIndex, $item['type']);
    }

    /**
     * @covers Fobia\Collections\ItemList::each
     */
    public function testEachReturnFallse()
    {
        $this->object->each(function(&$item, $index) {
            $item['type'] = 'each_' . $index;
            if ($index >= 5) {
                return false;
            }
        });

        $item = $this->object->itemAt(5);
        $this->assertEquals('each_5', $item['type']);

        $item = $this->object->itemAt(6);
        $this->assertEquals('new', $item['type']);
    }
    
    /**
     * @covers Fobia\Collections\ItemList::each
     */
    public function testEachWithArg()
    {
        $this->object->each(function(&$item, $index, $arg) {
            $item['type'] = $arg . '_' . $index;
        }, 'arg');

        $item = $this->object->itemAt(0);
        $this->assertEquals('arg_0', $item['type']);
    }
    
    /**
     * @covers Fobia\Collections\ItemList::set
     */
    public function testSet()
    {
        $this->object->set('type', 'set')
                ->set('name', 'set');

        $item = $this->object->itemAt(0);
        $this->assertEquals('set', $item['type']);
        $this->assertEquals('set', $item['name']);
    }
    
}