<?php

namespace Classes;

use Exception;

class ToDoList
{
	private ?User $user = null;
	private array $items = [];

	/**
	 * Constructor
	 */
	public function __construct(User $user = null)
	{
		$this->setUser($user);
	}

	/**
	 * Get the object description
	 */
	public function __toString(): string
	{
		return $this->getUser()->getFullName() . '\'s TODoList: ' . count($this->getItems()) . ' items';
	}

	/**
	 * Check if an item is in the ToDoList
	 */
	public function hasItem(string $name): bool
	{
		return array_key_exists($name, array_column($this->getItems(), 'name'));
		// return in_array($item->getName(), array_column($this->getItems(), 'name'));
	}

	/**
	 * Add an item to the ToDoList
	 */
	public function add(Item $item): ToDoList
	{
		// Throw an exception if last item was created less than 30 minutes from the previous one
		if (count($this->getItems()) > 0 && $this->getItems()[count($this->getItems()) - 1]->getCreatedAt()->diffInMinutes() < 30) {
			throw new Exception('You can\'t create two items in less than 30 minutes');
		}

		// Throw an exception when we try to add more than 10 items
		if (count($this->getItems()) > 10) {
			throw new Exception('You can\'t create more than 10 items');
		}

		// Add item if its name is unique in the ToDoList
		if (!$this->hasItem($item->getName())) {
			$this->items[] = $item;
		} else {
			throw new Exception('Item name already in use');
		}

		return $this;
	}

	/**
	 * Check the ToDoList validity
	 */
	public function isValid(): bool
	{
		return count($this->items) >= 0 && count($this->items) <= 10;
	}

	/**
	 * Get the value of user
	 */
	public function getUser(): ?User
	{
		return $this->user;
	}

	/**
	 * Set the value of user
	 *
	 * @return self
	 */
	public function setUser($user): ToDoList
	{
		$this->user = $user;
		$this->user->setToDoList($this);

		return $this;
	}

	/**
	 * Get the value of items
	 */
	public function getItems(): array
	{
		return $this->items;
	}

	/**
	 * Set the value of items
	 *
	 * @return self
	 */
	public function setItems($items): ToDoList
	{
		$this->items = $items;

		return $this;
	}
}