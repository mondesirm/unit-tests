<?php

namespace Tests;

use Models\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function __construct()
    {
        // Populate with correct data
        parent::__construct('Item', [
            'name' => 'New Item',
            'content' => str_repeat('a', 1000), // 1000 characters
        ]);
    }

    public function getItem(): Item
    {
        // Populate item with previously provided data
        return new Item(...$this->getProvidedData());
    }

    public function testValidItem(): void
    {
        $this->assertTrue($this->getItem()->isValid());
    }

    public function testInvalidContent(): void
    {
        // Use an invalid content
        $this->expectException(\Exception::class);
        $this->getItem()->setContent(str_repeat('a', 1001));
    }
}
