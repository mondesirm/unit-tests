<?php

namespace Tests;

use Classes\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
	public function testAge()
	{
		$data = ['John', 'Doe', 'john@doe.com', Carbon::now()->subYear(31), '1234567890'];

		$user = new User($data);
		$this->assertEquals(31, $user->getBirthDate()->age);
	}

	public function testInvalidAge()
	{
		$data = ['', '', '', Carbon::now()->subDecade(), '1234567890'];

		$user = new User($data);
		$this->assertFalse($user->isValid());
	}

	public function testInvalidEmail()
	{
		$data = ['', '', 'john.doe@com', Carbon::now()->subYear(31), '1234567890'];

		$user = new User($data);
		$this->assertFalse($user->isValid());
	}

	public function testPasswordTooShort()
	{
		$data = ['John', 'DOE', 'john@doe.com', Carbon::now()->subYear(31), '1234'];
		$user = new User($data);
		$this->assertFalse($user->isValid());
	}

	public function testPasswordTooLong()
	{
		$data = ['John', 'DOE', 'john@doe.com', Carbon::now()->subYear(31), '1234efsssssssssssssssssssfdfgfdgdfgfgfgfffggffdsssssssssqderzrezrezreerzerezerererzzererzreezrzerez'];
		$user = new User($data);
		$this->assertFalse($user->isValid());
	}

	public function testValidUser()
	{
		$data = ['John', 'DOE', 'john@doe.com', Carbon::now()->subYear(31), '1234567890'];

		$user = new User($data);
		$this->assertTrue($user->isValid());
	}

	public function testObjectGiven()
	{
		$data = [
			'password' => '1234567890',
			'firstName' => 'John',
			'birthDate' => '1990-01-01',
			'email' => 'johndoe.com',
			'lastName' => 'DOE',
		];

		$user = new User($data);
		$this->assertFalse($user->isValid());
	}
}
