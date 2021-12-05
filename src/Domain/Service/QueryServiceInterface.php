<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Domain\Service;

use takaram\CsvQuery\Domain\Model\Query;
use takaram\CsvQuery\Domain\Model\Table;

interface QueryServiceInterface
{
    public function execute(Query $query): Table;
}
