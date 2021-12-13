<?php

namespace Tests;

use Classes\App;
use Classes\Logger;
use PHPUnit\Framework\TestCase;
use Classes\Item;

class ItemTest extends TestCase
{

    public function createItemWithMoreThan1000Caractere(){
        $name= 'nameItem';
        $content = 'lessThan1000carateres';
        $item = new Item($name, $content);
    
        $this->assertEquals(false, $item->isValid());
        //Mock ???
            /* $todoList = $this->createMock(ToDoList::class);
    $todoList
        ->expects($this->once())
        ->method('getContentLength')
        ->willReturn('1001');
    }*/
    }

public function createValidItem(){
    $name= 'nameItem';
    $content = 'lessThan1000carateres';
    $item = new Item($name, $content);

    $this->assertEquals(true, $item->isValid());
}
}
