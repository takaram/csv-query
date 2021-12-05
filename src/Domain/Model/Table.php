<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Domain\Model;

use takaram\CsvQuery\Domain\Exception as DomainException;
use takaram\CsvQuery\lib\ReadonlyTrait;

class Table
{
    use ReadonlyTrait;

    private static array $__readonlyProperties = ['name', 'columns', 'data'];

    /**
     * @param TableName $name
     * @param list<TableColumn> $columns
     * @param list<list<string>> $data
     * @throws DomainException
     */
    public function __construct(
        private TableName $name,
        private array     $columns,
        private array     $data,
    )
    {
        $columnCount = count($columns);
        foreach ($data as $index => $row) {
            if (count($row) !== $columnCount) {
                throw new DomainException("Size of row #$index does not match column size");
            }
        }
    }
}
