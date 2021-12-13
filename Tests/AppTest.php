<?php

namespace Tests;

use Classes\App;
use Classes\Logger;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
	public function testAppRunning()
	{
		// Create mock
		$mock = $this->createMock(Logger::class);

		// Configure the mock
		$mock->expects($this->once())
			->method('log')
			->with('App has started');

			
		// Run app with mock
		$app = new App($mock);
	}
}