<?php

namespace Models;

use Carbon\Carbon;
use PharIo\Manifest\Email;

class User
{
	private ?string $firstName = null;
	private ?string $lastName = null;
	private ?string $email = null;
	public ?string $plainTextPassword = null;
	private ?string $password = null;
	private ?Carbon $birthDate = null;
	private ?ToDoList $toDoList = null;

	public function __construct($args)
	{
		if (count($args) >= 5) {
			$i = 0;

			// Iterate over User properties
			foreach ($this as $key => $value) {
				// Skip if the key is among these values (they'll be set later differently)
				if (in_array($key, ['plainTextPassword', 'toDoList'])) {
					continue;
				}

				// Dynamic setter
				$setter = 'set' . ucfirst($key);

				if (array_key_exists($key, $args)) {
					// Set the value if an object was passed
					$this->$setter($args[$key]);
				} else {
					// Set the value if an array was passed
					$this->$setter($args[$i]);
				}

				// Increment the counter (used if it's an array)
				$i++;
			}
		}

		// If no ToDoList was passed, create a new one by default
		$this->setToDoList(isset($args[5]) ? $args[5] : new ToDoList($this)); 
	}

	/**
	 * Get the user description
	 */
	public function __toString(): string
	{
		return $this->isValid()
			? $this->getFullName() . ' (' . $this->getEmail() . ' | ' . $this->getBirthDate()->age . ' yo): ' . ($this->getToDoList() == null ? 'Without ToDoList' : 'With ToDoList')
			: 'Invalid user'
		;
	}

	/**
	 * Get the user's full name
	 */
	public function getFullName(): string
	{
		return $this->getFirstName() . ' ' . $this->getLastName();
	}

	/**
	 * Check if the user is valid
	 */
	public function isValid(bool $return = false): bool
	{
		$errors = [];

		foreach ($this as $key => $value) {
			// Remove camelCase format
			$key = strtolower(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key));

			// If empty
			if (empty($value)) {
				$errors[] = "The $key field is required";
			}

			// If not a valid email
			if ($key == 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
				$errors[] = "Email is not valid";
			}

			// If user is not over 13 years old
			if ($key == 'birth date' && $this->getBirthDate()->age < 13) {
				$errors[] = "User must be over 13 years old and not " . $this->getBirthDate()->age . " years old";
			}

			// If password length is less than 8 caractere or more than 40 caractere
			if ($key == 'password' && (strlen($this->plainTextPassword) < 8 || strlen($this->plainTextPassword) > 40)) {
				$errors[] = "The password needs to be between 8 and 40 characters.";
			}
		}

		if ($return && !empty($errors)) {
			print_r($errors);
		}

		return empty($errors);
	}

	/* public function isValid(Validator $validator = null): bool
	{
		$errors = [];

		foreach ($this as $key => $value) {
			// Remove camelCase format
			$key = strtolower(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key));

			// If empty
			if (empty($value)) {
				$errors[] = "The $key field is required";
			}

			// If not a valid email
			// if ($key == 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
			if ($key == 'email' && !empty($value) && !$validator->checkEmail($value)) {
				$errors[] = "The $key field is not a valid email";
			}

			// If user is not over 13 years old
			if ($key == 'birth date' && $this->getBirthDate()->age < 13) {
				$errors[] = "The user must be over 13 years old and not " . $this->getBirthDate()->age . " years old";
			}
		}

		// !empty($errors) ? print_r($errors) : false;

		return empty($errors);
	} */

	/**
	 * Get the value of firstName
	 */
	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	/**
	 * Set the value of firstName
	 *
	 * @return self
	 */
	public function setFirstName(string $firstName): User
	{
		$this->firstName = $firstName;

		return $this;
	}

	/**
	 * Get the value of lastName
	 */
	public function getLastName(): ?string
	{
		return $this->lastName;
	}

	/**
	 * Set the value of lastName
	 *
	 * @return self
	 */
	public function setLastName(string $lastName): User
	{
		$this->lastName = $lastName;

		return $this;
	}

	/**
	 * Get the value of email
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * Set the value of email
	 *
	 * @return self
	 */
	public function setEmail(mixed $email): User
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get the value of password
	 */
	public function getPassword(): ?string
	{
		return $this->password;
	}

	/**
	 * Set the value of password
	 *
	 * @return self
	 */
	public function setPassword(string $password): User
	{
		$this->plainTextPassword = $password;
		$this->password = password_hash($password, PASSWORD_BCRYPT);

		return $this;
	}

	/**
	 * Get the value of birthDate
	 */
	public function getBirthDate(): ?Carbon
	{
		return $this->birthDate;
	}

	/**
	 * Set the value of birthDate
	 *
	 * @return self
	 */
	public function setBirthDate(mixed $birthDate): User
	{
		$this->birthDate = ($birthDate instanceof Carbon) ? $birthDate : Carbon::createFromDate(...explode('-', $birthDate));

		return $this;
	}

	/**
	 * Get the value of toDoList
	 */
	public function getToDoList(): ?ToDoList
	{
		// TODO Check if the toDoList has items
		// return $this->toDoList ? $this->toDoList : 'No ToDoList';
		return $this->toDoList;
	}

	/**
	 * Set the value of toDoList
	 *
	 * @return self
	 */
	public function setToDoList(?ToDoList $toDoList = null): User
	{
		$this->toDoList = $toDoList ? $toDoList : new ToDoList($this);

		return $this;
	}
}
