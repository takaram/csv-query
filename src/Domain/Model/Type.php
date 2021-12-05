<?php
declare(strict_types=1);

namespace takaram\CsvQuery\Domain\Model;

/**
 * @method static self INTEGER
 * @method static self FLOAT
 * @method static self VARCHAR
 * @method static self DATE
 * @method static self TIMESTAMP
 */
class Type
{
    private const INTEGER = 'integer';
    private const FLOAT = 'float';
    private const VARCHAR = 'varchar';
    private const DATE = 'date';
    private const TIMESTAMP = 'timestamp';

    private function __construct(
        private string $value,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public static function __callStatic(string $name, array $args): self
    {
        $types = ['INTEGER', 'FLOAT', 'VARCHAR', 'DATE', 'TIMESTAMP'];
        if (in_array($name, $types)) {
            return new self(constant('self::' . $name));
        }
        throw new \Exception("Undefined Type: {$name}");
    }

    public function isAcceptable(string $value): bool
    {
        return match ($this->value) {
            self::INTEGER => $this->isPossiblyInteger($value),
            self::FLOAT => $this->isPossiblyFloat($value),
            self::VARCHAR => $this->isPossiblyVarchar($value),
            self::DATE => $this->isPossiblyDate($value),
            self::TIMESTAMP => $this->isPossiblyTimestamp($value),
        };
    }

    private function isPossiblyInteger(string $value): bool
    {
        return (bool)preg_match('/^[+-]?\d+$/', $value);
    }

    private function isPossiblyFloat(string $value): bool
    {
        return is_numeric($value);
    }

    private function isPossiblyVarchar(string $value): bool
    {
        return true;
    }

    private function isPossiblyDate(string $value): bool
    {
        return (bool)preg_match('/^\d{4}(?<delim>[-\/])(0?[1-9]|1[0-2])\k<delim>(0?[1-9]|[12][0-9]|3[01])$/', $value);
    }

    private function isPossiblyTimestamp(string $value): bool
    {
        if (!str_contains($value, ' ')) {
            return false;
        }

        [$date, $time] = explode(' ', $value, 2);
        return $this->isPossiblyDate($date) && preg_match('/^([01]?\d|2[0-3]):([0-5]?\d):([0-5]?\d)$/', $time);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
