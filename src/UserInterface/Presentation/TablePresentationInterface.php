<?php
declare(strict_types=1);

namespace takaram\CsvQuery\UserInterface\Presentation;

use takaram\CsvQuery\Application\TableData;

interface TablePresentationInterface
{
    public function render(TableData $table, string $delimiter, bool $showHeader): void;
}
