<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Domain\Repository;

use takaram\CsvQuery\Domain\Model\Table;

interface TableRepositoryInterface
{
    public function save(Table $table): void;
}
