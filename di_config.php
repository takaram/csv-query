<?php
declare(strict_types=1);

use takaram\CsvQuery\Domain\Repository\TableRepositoryInterface;
use takaram\CsvQuery\Domain\Service\QueryServiceInterface;
use takaram\CsvQuery\Infrastructure\Repository\TableRepository;
use takaram\CsvQuery\Infrastructure\Service\QueryService;
use Vimeo\MysqlEngine\Php8\FakePdo;

return [
    QueryServiceInterface::class => DI\autowire(QueryService::class),
    TableRepositoryInterface::class => DI\autowire(TableRepository::class),

    PDO::class => DI\factory(function () {
        $pdo = new FakePdo('mysql:hostname=localhost;dbname=csv_query;', 'root', '');
        $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }),
];
