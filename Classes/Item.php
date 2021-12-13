<?php

namespace Classes;

use Exception;
use Carbon\Carbon;

class Item
{
	private string $name = 'New Item';
	private string $content = '';
	private $creationDate = null;

	/**
	 * Constructor
	 */ 
	public function __construct(string $name = '', $content = '')
	{
		$this->setName($name);
		$this->setContent($content);
		$this->setCreationDate(Carbon::now());
	}

	/**
	 * Get the object description
	 */ 
	public function __toString(): string
	{
		return "Item {$this->getName()} ({$this->getCreationDate()}): {$this->getContent()}";
	}

	/**
	 * Check the Item validity
	 */
	public function isValid(): bool
	{
		return strlen($this->getContent()) <= 1000;
	}

	/**
	 * Get the value of name
	 */ 
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * Set the value of name
	 *
	 * @return self
	 */ 
	public function setName($name): Item
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get the value of content
	 */ 
	public function getContent(): string
	{
		return $this->content;
	}

	/**
	 * Set the value of content
	 *
	 * @return self
	 */ 
	public function setContent($content): Item
	{
		if (strlen($content) <= 1000) {
			$this->content = $content;
		} else {
			throw new Exception('You can\'t create an item with more than 1000 characters in its content.');
		}

		return $this;
	}

	/**
	 * Get the value of creationDate
	 */
	public function getCreationDate(): Carbon
	{
		return $this->creationDate;
	}

	/**
	 * Set the value of creationDate
	 *
	 * @return self
	 */
	public function setCreationDate(Carbon $creationDate): Item
	{
		$this->creationDate = $creationDate;

		return $this;
	}
}