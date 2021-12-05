<?php
declare(strict_types=1);

namespace takaram\CsvQuery\UserInterface;

use GetOpt\ArgumentException\Unexpected;
use GetOpt\GetOpt;
use GetOpt\Operand;
use takaram\CsvQuery\Application\ApplicationService;
use takaram\CsvQuery\UserInterface\Presentation\TableCsvPresentation;

class Command
{
    public const SUCCESS = 0;
    public const FAIL = 1;

    public function __construct(
        private ApplicationService $application
    )
    {
    }

    public function execute(array $args): int
    {
        try {
            $options = $this->parseArgs($args);
        } catch (Unexpected $e) {
            echo $e->getMessage(), PHP_EOL;
            return self::FAIL;
        }

        $inputDelimiter = $options['delimiter-in'] ?? $options['delimiter'];
        $outputDelimiter = $options['delimiter-out'] ?? $options['delimiter'];

        $table = $this->application->run($options['query'], $inputDelimiter, !$options['no-header-in'], ...$options['filePaths']);

        $presentation = new TableCsvPresentation();
        $presentation->render($table, $outputDelimiter, !$options['no-header-out']);

        return self::SUCCESS;
    }

    /**
     * @param list<string> $args
     * @return array<string, string>
     */
    private function parseArgs(array $args): array
    {
        $getopt = new GetOpt([
            ['d', 'delimiter', GetOpt::REQUIRED_ARGUMENT, 'CSV delimiters used for both input and output. Default value is comma (,).', ','],
            [null, 'delimiter-in', GetOpt::REQUIRED_ARGUMENT, 'CSV delimiters used for input. This option overrides -d option.'],
            [null, 'delimiter-out', GetOpt::REQUIRED_ARGUMENT, 'CSV delimiters used for output. This option overrides -d option.'],
            ['H', 'no-header-in', GetOpt::NO_ARGUMENT, 'Declares that the first line of the input is not a header line. Each column is named c1, c2, c3, and so on.'],
            ['O', 'no-header-out', GetOpt::NO_ARGUMENT, 'Suppresses to print a header line.'],
        ]);
        $getopt->addOperands([
            Operand::create('query', Operand::REQUIRED),
            Operand::create('filePaths', Operand::MULTIPLE),
        ]);
        $getopt->process($args);

        $result = [];
        foreach (['delimiter', 'delimiter-in', 'delimiter-out', 'no-header-in', 'no-header-out'] as $item) {
            $result[$item] = $getopt->getOption($item);
        }
        $result['query'] = $getopt->getOperand('query');
        $result['filePaths'] = $getopt->getOperand('filePaths') ?? [];

        return $result;
    }
}
