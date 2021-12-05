<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Domain\Model;

use takaram\CsvQuery\Domain\Exception as DomainException;
use takaram\CsvQuery\lib\ReadonlyTrait;

class TableName
{
    use ReadonlyTrait;

    /**
     * @param non-empty-string $value
     * @throws DomainException
     */
    public function __construct(
        private string $value,
    )
    {
        if ($value === '') {
            throw new DomainException('Table name cannot be empty');
        }
    }
}
