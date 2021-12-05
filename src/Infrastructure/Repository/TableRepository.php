<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Infrastructure\Repository;

use takaram\CsvQuery\Domain\Model\Table;
use takaram\CsvQuery\Domain\Model\TableColumn;
use takaram\CsvQuery\Domain\Repository\TableRepositoryInterface;

class TableRepository implements TableRepositoryInterface
{
    public function __construct(
        private \PDO $pdo,
    )
    {
    }

    /**
     * @param Table $table
     * @return void
     */
    public function save(Table $table): void
    {
        $createTableSql = $this->getCreateTableSql($table);
        $this->pdo->exec($createTableSql);

        $insertSql = $this->getInsertSql($table);
        $stmt = $this->pdo->prepare($insertSql);
        foreach ($table->data as $row) {
            $stmt->execute($row);
        }
    }

    /**
     * @param Table $table
     * @return string
     */
    private function getCreateTableSql(Table $table): string
    {
        $tableName = $table->name->value;
        $columnDefinitions = array_map(function (TableColumn $column): string {
            $type = (string)$column->type;
            if ($type === 'varchar') {
                $type = 'varchar(255)';
            }
            return "`{$column->name}` {$type}";
        }, $table->columns);

        $sql = "CREATE TABLE `{$tableName}` (" . implode(',', $columnDefinitions) . ")";
        // php-mysql-engine requires charset
        $sql .= ' CHARACTER SET utf8mb4;';

        return $sql;
    }

    /**
     * @param Table $table
     * @return string
     */
    private function getInsertSql(Table $table): string
    {
        $tableName = $table->name->value;
        $colCount = count($table->data[0]);

        $colList = implode(',', array_map(fn(TableColumn $column) => "`{$column->name}`", $table->columns));

        return "INSERT INTO `{$tableName}` ({$colList}) VALUES (" . implode(',', array_fill(0, $colCount, '?')) . ')';
    }
}
