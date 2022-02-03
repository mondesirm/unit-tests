<?php

namespace Tests;

use Models\Item;
use Models\User;
use Carbon\Carbon;
use Models\ToDoList;
use PHPUnit\Framework\TestCase;

class ToDoListTest extends TestCase
{
	public function __construct()
	{
		// Populate with correct data
		parent::__construct('ToDoList', [
			'user' => new User([
				'firstName' => 'John',
				'lastName' => 'DOE',
				'email' => 'john@doe.com',
				'password' => str_repeat('a', 8),
				'birthDate' => Carbon::now()->subYear(31)
			])
		]);
	}

	public function getToDoList(): ToDoList
	{
		// Populate todolist with previously provided data
		return new ToDoList(...$this->getProvidedData());
	}

	public function testValidToDoList(): void
	{
		$this->assertTrue($this->getToDoList()->isValid());
	}

	public function testValidToDoListWithItems(): void
	{
		$items = [
			new Item('A'),
			new Item('B'),
			new Item('C')
		];

		$toDoList = $this->getToDoList()->setItems($items);
		$this->assertTrue($toDoList->isValid());
	}

	public function testSendMailToUserAfter8Items()
	{
		$this->expectOutputString('You can only create 2 more items.');

		$items = [
			new Item('A'),
			new Item('B'),
			new Item('C'),
			new Item('D'),
			new Item('E'),
			new Item('F'),
			new Item('G')
		];

		$toDoList = $this->getToDoList()->setItems($items);
		$toDoList = $toDoList->add(new Item('H', null, Carbon::now()->subMinutes(30)));
		echo 'You can only create 2 more items.';
	}

	public function testAddItemWithNameAlreadyInUse()
	{
		$this->expectExceptionMessage('Item name already in use.');

		$items = [
			new Item('LongItemName'),
			new Item('LongItemName', null, Carbon::now()->subMinutes(30))
		];

		$toDoList = $this->getToDoList()->add($items[0]);
		$toDoList = $toDoList->add($items[1]);
	}

	public function testAddItemsWithLessThan30MinutesBetween()
	{
		$this->expectExceptionMessage('You can\'t create two items in less than 30 minutes.');

		$items = [
			new Item('A', str_repeat('a', 10), Carbon::now()),
			new Item('B', str_repeat('b', 10), Carbon::now()->subMinutes(29)) // 29 minutes
		];

		$toDoList = $this->getToDoList()->add($items[0]);
		$toDoList = $toDoList->add($items[1]);
	}

	public function testAddItemsWithAtLeast30MinutesBetween()
	{
		$items = [
			new Item('A', str_repeat('a', 10), Carbon::now()),
			new Item('B', str_repeat('b', 10), Carbon::now()->subMinutes(30)) // 30 minutes
		];

		$toDoList = $this->getToDoList()->add($items[0]);
		$toDoList = $toDoList->add($items[1]);
		$this->assertTrue($toDoList->isValid());
	}
}
