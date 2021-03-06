<?php

namespace Models;

use Carbon\Carbon;

class Item
{
	public ?string $name = 'New Item';
	private ?string $content = null;
	private ?Carbon $creationDate = null;

	/**
	 * Constructor
	 */ 
	public function __construct(string $name = '', $content = null, mixed $creationDate = null)
	{
		$this->setName($name ?: $this->getName());
		$this->setContent($content);
		$this->setCreationDate($creationDate ?: Carbon::now());
	}

	/**
	 * Get the object description
	 */ 
	public function __toString(): string
	{
		return "Item {$this->getName()} ({$this->getCreationDate()->diffForHumans()}): {$this->getContent()}";
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
	public function getName(): ?string
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
	public function getContent(): ?string
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
			throw new \Exception('You can\'t create an item with more than 1000 characters in its content.');
		}

		return $this;
	}

	/**
	 * Get the value of creationDate
	 */
	public function getCreationDate(): ?Carbon
	{
		return $this->creationDate;
	}

	/**
	 * Set the value of creationDate
	 *
	 * @return self
	 */
	public function setCreationDate(mixed $creationDate): Item
	{
		$this->creationDate = ($creationDate instanceof Carbon) ? $creationDate : Carbon::createFromDate(...explode('-', $creationDate));

		return $this;
	}
}