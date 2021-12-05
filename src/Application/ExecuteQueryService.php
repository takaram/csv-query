<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Application;

use takaram\CsvQuery\Domain\Model\Query;
use takaram\CsvQuery\Domain\Service\QueryServiceInterface;

class ExecuteQueryService
{
    public function __construct(
        private QueryServiceInterface $queryService,
    )
    {
    }

    public function execute(string $sql): TableData
    {
        $query = new Query($sql);
        $table = $this->queryService->execute($query);

        return new TableData($table);
    }
}
