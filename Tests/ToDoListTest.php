<?php

namespace Tests;

use Classes\Item;
use Classes\ToDoList;
use Classes\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ToDoListTest extends TestCase
{
	// public function testObjectGiven()
	// {
	// 	$items = [
	// 		new Item(['A']), 
	// 		new Item(['B']), 
	// 		new Item(['C'])
	// 	];

	// 	$user = new User($items);
	// 	$this->assertFalse($user->isValid());
	// }

	public function sendMailToUserWhenThe8ItemAreSet()
	{

			/*	$todoList = $this->createMock(ToDoList::class)
			->method('getItems')
			->willReturn('listItems');*/
		$emailSenderService = $this->createMock(EmailSenderService::class);
		$emailSenderService
			->expects($this->once())
			->method('sendMail')
			->willReturn('true');
	}


	public function userCanOnlyPossesOneToDolist()
	{
	}

	public function toDoListContainMoreThan10Items()
	{
	}

	public function toDoListContainBetween0And10Items()
	{
	}

	public function addItemWithItemNameAlreadyUse()
	{
		$this->expectExceptionMessage('Item name already use');

		$name = 'nameItem';
		$content = 'lessThan1000carateres';
		$item1 = new Item($name, $content);

		$name = 'nameItem';
		$content = 'lessThan1000carateres';
		$item2 = new Item($name, $content);
		$item2->setCreationDate($item1->getCreationDate()->addMinutes(30));

		$data = [
			'password' => '1234567890',
			'firstName' => 'John',
			'birthDate' => '1990-01-01',
			'email' => 'johndoe.com',
			'lastName' => 'DOE',
		];

		$user = new User($data);

		$toDoList = new ToDoList($user);
		$toDoList->add($item1);
		$toDoList->add($item2);
	}

	public function add2ItemsWithLessThan30MinutesBetween()
	{
		$this->expectExceptionMessage('You can\'t create two items in less than 30 minutes');

		$name = 'nameItem';
		$content = 'lessThan1000carateres';
		$item1 = new Item($name, $content);

		$name = 'nameItem';
		$content = 'lessThan1000carateres';
		$item2 = new Item($name, $content);

		$data = [
			'password' => '1234567890',
			'firstName' => 'John',
			'birthDate' => '1990-01-01',
			'email' => 'johndoe.com',
			'lastName' => 'DOE',
		];

		$user = new User($data);

		$toDoList = new ToDoList($user);
		$toDoList->add($item1);
		$toDoList->add($item2);
	}

	public function addValidItem()
	{
		$name = 'nameItem';
		$content = 'lessThan1000carateres';
		$item = new Item($name, $content);

		$data = [
			'password' => '1234567890',
			'firstName' => 'John',
			'birthDate' => '1990-01-01',
			'email' => 'johndoe.com',
			'lastName' => 'DOE',
		];

		$user = new User($data);

		$toDoList = new ToDoList($user);
		$toDoList->add($item);
		$this->assertEquals($item, $toDoList->getItems()[0]);
	}
}
