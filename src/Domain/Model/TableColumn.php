<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Domain\Model;

use takaram\CsvQuery\Domain\Exception as DomainException;
use takaram\CsvQuery\lib\ReadonlyTrait;

class TableColumn
{
    use ReadonlyTrait;

    private static array $__readonlyProperties = ['name', 'type'];

    /**
     * @param string $name
     * @param Type $type
     * @throws DomainException
     */
    public function __construct(
        private string $name,
        private Type   $type,
    )
    {
        if ($name === '') {
            throw new DomainException('Column name cannot be empty');
        }
    }
}
