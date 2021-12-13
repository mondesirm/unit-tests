<?php

namespace Classes;

class Logger
{
	private string $text = '';

	public function log($text)
	{
		$this->setText($text);
		echo $text;
		return $text;
	}

	public function getText()
	{
		return $this->text;
	}

	public function setText($text)
	{
		$this->text = $text;
	}
}