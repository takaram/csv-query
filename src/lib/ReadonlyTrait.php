<?php
declare(strict_types=1);

namespace takaram\CsvQuery\lib;

/**
 * This trait defines __get() to access allowed properties.
 * If the class has a static array property `$__readonlyProperties`, properties listed in it becomes accessible.
 * Otherwise, $value becomes accesible.
 *
 * TODO: Remove this trait and use readonly property when dropping PHP8.0 support
 */
trait ReadonlyTrait
{
    public function __get(string $name): mixed
    {
        $allowedProperties = static::$__readonlyProperties ?? ['value'];
        if (property_exists($this, $name) && in_array($name, $allowedProperties)) {
            return $this->$name;
        }
        throw new \OutOfBoundsException('Undefined property: ' . $name);
    }

    public function __isset(string $name): bool
    {
        $allowedProperties = static::$__readonlyProperties ?? ['value'];
        return isset($this->$name) && in_array($name, $allowedProperties);
    }
}
