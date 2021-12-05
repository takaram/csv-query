<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Infrastructure\Service;

use takaram\CsvQuery\Domain\Model\Query;
use takaram\CsvQuery\Domain\Model\Table;
use takaram\CsvQuery\Domain\Model\TableColumn;
use takaram\CsvQuery\Domain\Model\TableName;
use takaram\CsvQuery\Domain\Model\Type;
use takaram\CsvQuery\Domain\Service\QueryServiceInterface;

class QueryService implements QueryServiceInterface
{
    public function __construct(
        private \PDO $pdo,
    )
    {
    }

    /**
     * @param Query $query
     * @return Table
     * @throws \takaram\CsvQuery\Domain\Exception
     */
    public function execute(Query $query): Table
    {
        $statement = $this->pdo->query($query->value);

        $tableName = new TableName('result');
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $columns = $this->getColumns(array_keys($data[0]));

        return new Table($tableName, $columns, $data);
    }

    private function getColumns(array $keyNames): array
    {
            // TODO: Get exact type
        $columns = array_map(fn (string $name) => new TableColumn($name, Type::VARCHAR()), $keyNames);

        return $columns;
    }
}
