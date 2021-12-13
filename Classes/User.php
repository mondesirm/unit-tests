<?php

namespace Classes;

use Carbon\Carbon;

class User
{
	private string $firstName = '';
	private string $lastName = '';
	private string $email = '';
	private string $password = '';
	private ?Carbon $birthDate = null;
	private ?ToDoList $toDoList = null;

	public function __construct($args)
	{
		if (count($args) == 5) {
			$i = 0;

			foreach ($this as $key => $value) {
				$setter = 'set' . ucfirst($key);

				if (array_key_exists($key, $args)) {
					$this->$setter($args[$key]);
				} else {
					$this->$setter($args[$i]);
				}

				$i++;
			}
		}
	}

	/**
	 * Get the user description
	 */
	public function __toString(): string
	{
		return $this->getFullName() . ' (' . $this->getEmail() . ' | ' . $this->getBirthDate()->age . ' yo): ' . $this->getToDoList() == null ? 'Without ToDoList' : 'With ToDoList';
	}

	/**
	 * Get the user's full name
	 */
	public function getFullName(): string
	{
		return $this->firstName . ' ' . $this->lastName;
	}

	/**
	 * Check if the user is valid
	 */
	public function isValid(): bool
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
			if ($key == 'password' && strlen($this->getPassword()) > 8 && strlen($this->getPassword()) < 40) {
				$errors[] = "The password needs to be between 8 and 40 caractere";
			}
		}

		// !empty($errors) ? print_r($errors) : false;

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
	public function getFirstName(): string
	{
		return $this->firstName;
	}

	/**
	 * Set the value of firstName
	 *
	 * @return self
	 */
	public function setFirstName($firstName): User
	{
		$this->firstName = $firstName;

		return $this;
	}

	/**
	 * Get the value of lastName
	 */
	public function getLastName(): string
	{
		return $this->lastName;
	}

	/**
	 * Set the value of lastName
	 *
	 * @return self
	 */
	public function setLastName($lastName): User
	{
		$this->lastName = $lastName;

		return $this;
	}

	/**
	 * Get the value of email
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * Set the value of email
	 *
	 * @return self
	 */
	public function setEmail($email): User
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get the value of password
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * Set the value of password
	 *
	 * @return self
	 */
	public function setPassword($password): User
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Get the value of birthDate
	 */
	public function getBirthDate(): Carbon
	{
		return $this->birthDate;
	}

	/**
	 * Set the value of birthDate
	 *
	 * @return self
	 */
	public function setBirthDate($birthDate): User
	{
		$this->birthDate = ($birthDate instanceof Carbon) ? $birthDate : Carbon::createFromDate(...explode('-', $birthDate));

		return $this;
	}

	/**
	 * Get the value of toDoList
	 */
	public function getToDoList(): ToDoList
	{
		return $this->toDoList;
	}

	/**
	 * Set the value of toDoList
	 *
	 * @return self
	 */
	public function setToDoList($toDoList = null): User
	{

		$this->toDoList = $toDoList ? $toDoList : new ToDoList($this);

		return $this;
	}
}