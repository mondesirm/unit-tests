<?php

namespace Models;

use Exception;
use Models\User;
use Models\EmailSenderService;

class ToDoList
{
	private ?User $user = null;
	private array $items = [];

	/**
	 * Constructor
	 */
	public function __construct(User $user = null, array $items = [])
	{
		$this->setUser($user);
		$this->setItems($items);
	}

	/**
	 * Get the object description
	 */
	public function __toString(): string
	{
		return $this->getUser()->getFullName() . '\'s ToDoList: ' . count($this->getItems()) . (count($this->getItems()) > 1 ? ' items' : ' item');
	}

	/**
	 * Check if an item is in the ToDoList
	 */
	public function hasItem(string $name): bool
	{
		$names = array_map(function ($item) {
			return $item->getName();
		}, $this->getItems());

		return in_array($name, $names);
	}

	/**
	 * Add an item to the ToDoList
	 */
	public function add(Item $item): ToDoList
	{
		$lastItem = count($this->getItems()) > 0 ? $this->getItems()[count($this->getItems()) - 1] : 0;

		// Throw an exception if last item was created less than 30 minutes from the previous one
		if (count($this->getItems()) > 0 && abs($item->getCreationDate()->diffInMinutes() - $lastItem->getCreationDate()->diffInMinutes()) < 30) {
			throw new Exception('You can\'t create two items in less than 30 minutes.');
		}

		// Send an email to the User after 8 items
		if (count($this->getItems()) == 8) {
			EmailSenderService::sendMail($this->getUser()->getEmail(), 'You can only create 2 more items.');
		}

		// Throw an exception when we try to add more than 10 items
		if (count($this->getItems()) > 10) {
			throw new Exception('You can\'t create more than 10 items');
		}

		// Add item if its name is unique in the ToDoList
		if (!$this->hasItem($item->getName())) {
			$this->items[] = $item;
		} else {
			throw new Exception('Item name already in use.');
		}

		return $this;
	}

	/**
	 * Check the ToDoList validity
	 */
	public function isValid(): bool
	{
		return count($this->items) >= 0 && count($this->items) <= 10 // Items count check
			&& array_unique(array_column($this->items, 'name')) === array_column($this->items, 'name') // Unique items names check

			// Uncomment below to also check validity on its properties
			/* && ($this->getUser()->isValid() || null) // User Check
			&& array_reduce($this->items, function ($carry, $item) {
				// Content check for each item
				return $carry && $item->isValid();
			}, true); */
		;
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
	public function setUser(User $user): ToDoList
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
	public function setItems(array $items): ToDoList
	{
		$this->items = $items;

		return $this;
	}
}