<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Application;

use takaram\CsvQuery\Domain\Exception as DomainException;
use takaram\CsvQuery\Domain\Factory\TableFactory;
use takaram\CsvQuery\Domain\Repository\TableRepositoryInterface;

class CreateTableService
{
    public function __construct(
        private TableRepositoryInterface $tableRepository,
        private TableFactory $tableFactory,
    )
    {
    }

    /**
     * @param \Iterator<list<string>> $inputIterator
     * @param string $tableName
     * @param bool $hasHeader
     * @return void
     * @throws DomainException
     */
    public function create(\Iterator $inputIterator, string $tableName, bool $hasHeader): void
    {
        if ($hasHeader) {
            $data = [];
            $header = $inputIterator->current();
        } else {
            $data = [$inputIterator->current()];
            $header = array_map(fn (int $n) => 'c' . $n, range(1, count($data[0])));
        }
        $inputIterator->next();

        while ($inputIterator->valid()) {
            // TODO: validate column size
            $data[] = $inputIterator->current();
            $inputIterator->next();
        }

        $table = $this->tableFactory->create($tableName, $header, $data);
        $this->tableRepository->save($table);
    }
}
