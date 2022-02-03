<?php

namespace Tests;

use Models\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
	public function __construct()
	{
		// Populate with correct data
		parent::__construct('User', [
			'firstName' => 'John',
			'lastName' => 'DOE',
			'email' => 'john@doe.com',
			'password' => str_repeat('a', 8), // 8 characters
			'birthDate' => Carbon::now()->subYear(31) // Over 13 years old
		]);
	}

	public function getUser(): User
	{
		// Populate user with previously provided data
		return new User($this->getProvidedData());
	}

	public function testValidUser(): void
	{
		$this->assertTrue($this->getUser()->isValid());
	}

	public function testUserIs31YearsOld(): void
	{
		$this->assertEquals(31, $this->getUser()->getBirthDate()->age);
	}

	public function testInvalidAge(): void
	{
		// Use an invalid birth date
		$user = $this->getUser()->setBirthDate(Carbon::now()->subDecade());
		$this->assertFalse($user->isValid());
	}

	public function testInvalidEmail(): void
	{
		// Use an invalid email
		$user = $this->getUser()->setEmail('john.doe@com');
		$this->assertFalse($user->isValid());
	}

	public function testTooShortPassword(): void
	{
		// Use an invalid and too short password
		$user = $this->getUser()->setPassword(str_repeat('a', 7));
		$this->assertFalse($user->isValid());
	}

	public function testTooLongPassword(): void
	{
		// Use an invalid and too long password
		$user = $this->getUser()->setPassword(str_repeat('a', 41));
		$this->assertFalse($user->isValid());
	}

	public function testArrayGiven(): void
	{
		// Use an array of correctly ordered values instead of an object
		$user = new User(array_values($this->getProvidedData()));
		$this->assertTrue($user->isValid());
	}
}