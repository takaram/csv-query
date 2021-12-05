<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Domain\Service;

use takaram\CsvQuery\Domain\Model\Type;

class TypeService
{
    /**
     * @param string[] $values
     * @return Type
     */
    public function determineType(array $values): Type
    {
        $typeList = [
            Type::INTEGER(),
            Type::FLOAT(),
            Type::TIMESTAMP(),
            Type::DATE(),
            Type::VARCHAR(),
        ];
        foreach ($values as $value) {
            $typeList = array_filter($typeList, fn(Type $type) => $type->isAcceptable($value));
            if (count($typeList) === 1) {
                break;
            }
        }
        return array_shift($typeList);
    }
}
