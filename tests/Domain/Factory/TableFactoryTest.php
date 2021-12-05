<?php
declare(strict_types=1);

namespace takaram\CsvQuery\tests\Domain\Factory;

use takaram\CsvQuery\Domain\Factory\TableFactory;
use takaram\CsvQuery\Domain\Model\Table;
use takaram\CsvQuery\Domain\Service\TypeService;
use PHPUnit\Framework\TestCase;

class TableFactoryTest extends TestCase
{
    private TableFactory $tableFactory;

    public function setUp(): void
    {
        $typeService = $this->createMock(TypeService::class);
        $this->tableFactory = new TableFactory($typeService);
    }

    public function testCreate()
    {
        $name = 'test1';
        $columns = ['foo', 'bar'];
        $data = [
            ['12', 'abc'],
            ['34', 'def'],
            ['56', 'ghi'],
            ];
        $table = $this->tableFactory->create($name, $columns, $data);

        $this->assertInstanceOf(Table::class, $table);
        $this->assertSame($name, $table->name->value);
    }
}
