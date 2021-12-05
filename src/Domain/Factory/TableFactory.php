<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Domain\Factory;

use takaram\CsvQuery\Domain\Exception as DomainException;
use takaram\CsvQuery\Domain\Model\Table;
use takaram\CsvQuery\Domain\Model\TableColumn;
use takaram\CsvQuery\Domain\Model\TableName;
use takaram\CsvQuery\Domain\Model\Type;
use takaram\CsvQuery\Domain\Service\TypeService;

class TableFactory
{
    public function __construct(
        private TypeService $typeService,
    )
    {
    }

    /**
     * @param string $tableName
     * @param list<string> $columnNames
     * @param list<list<string>> $data
     * @return Table
     * @throws DomainException
     */
    public function create(string $tableName, array $columnNames, array $data): Table
    {
        $tableName = new TableName($tableName);

        $transposedData = array_map(null, ...$data);
        if (count($transposedData) !== count($columnNames)) {
            throw new DomainException('Size of $columnNames and $data do not match');
        }
        $typeList = array_map([$this->typeService, 'determineType'], $transposedData);
        $columnList = array_map(fn(string $name, Type $type) => new TableColumn($name, $type), $columnNames, $typeList);

        return new Table($tableName, $columnList, $data);
    }
}
