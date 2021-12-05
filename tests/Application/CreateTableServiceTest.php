<?php
declare(strict_types=1);

namespace takaram\CsvQuery\tests\Application;

use takaram\CsvQuery\Application\CreateTableService;
use PHPUnit\Framework\TestCase;

class CreateTableServiceTest extends TestCase
{
    private CreateTableService $service;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateWithHeader()
    {
        $iterator = new \ArrayIterator([
            ['id', 'name'],
            ['1', 'John'],
            ['2', 'Alice'],
        ]);
    }
}
