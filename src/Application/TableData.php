<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Application;

use takaram\CsvQuery\Domain\Model\Table;

class TableData
{
    /** @var string */
    public string $name;

    /** @var list<string> */
    public array $columnNames;

    /** @var list<string> */
    public array $columnTypes;

    /** @var list<list<string|int|bool>> */
    public array $data;

    public function __construct(Table $table)
    {
        $this->name = $table->name->value;
        $this->columnNames = [];
        $this->columnTypes = [];
        $this->data = $table->data;

        foreach ($table->columns as $column) {
            $this->columnNames[] = $column->name;
            $this->columnTypes[] = strval($column->type);
        }
    }
}
