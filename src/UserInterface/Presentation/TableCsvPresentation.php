<?php
declare(strict_types=1);

namespace takaram\CsvQuery\UserInterface\Presentation;

use takaram\CsvQuery\Application\TableData;

class TableCsvPresentation implements TablePresentationInterface
{
    private const RECORD_DELIMITER = "\r\n";

    public function render(TableData $table, string $delimiter, bool $showHeader): void
    {
        if ($showHeader) {
            $this->printRow($table->columnNames, $delimiter);
        }
        foreach ($table->data as $row) {
            $this->printRow($row, $delimiter);
        }
    }

    /**
     * @param list<mixed> $row
     * @param string $delimiter
     * @return void
     */
    private function printRow(array $row, string $delimiter): void
    {
        echo implode($delimiter, $row), self::RECORD_DELIMITER;
    }
}
