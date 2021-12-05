<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Application;

class ApplicationService
{
    public function __construct(
        private CreateTableService $createTableService,
        private ExecuteQueryService $executeQueryService,
    )
    {
    }

    public function run(string $query, string $delimiter, bool $hasHeader, string ...$fileNames): TableData
    {
        // create tables
        // stdin
        if (empty($fileNames) || !stream_isatty(STDIN)) {
            $this->createTable('stdin', 'php://stdin', $delimiter, $hasHeader);
        }
        // other files
        foreach ($fileNames as $fileName) {
            $tableName = pathinfo($fileName, PATHINFO_FILENAME);
            $this->createTable($tableName, $fileName, $delimiter, $hasHeader);
        }

        // execute query
        return $this->executeQueryService->execute($query);
    }

    private function createTable(string $tableName, string $fileName, string $delimiter, bool $hasHeader): void
    {
        $fileObj = new \SplFileObject($fileName);
        $fileObj->setFlags(\SplFileObject::READ_CSV|\SplFileObject::SKIP_EMPTY|\SplFileObject::READ_AHEAD);
        $fileObj->setCsvControl($delimiter, '"', '');

        $iterator = $fileName === 'php://stdin' ? new \NoRewindIterator($fileObj) : $fileObj;
        $this->createTableService->create($iterator, $tableName, $hasHeader);

    }
}
