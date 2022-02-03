<?php

namespace Models;

class EmailSenderService
{
	public static function sendMail($email, $message, $subject = null, $options = null): void
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new \Exception('Invalid email address');
		}

		echo $message;
	}
}