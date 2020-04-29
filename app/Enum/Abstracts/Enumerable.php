<?php

declare(strict_types=1);

namespace App\Enum\Abstracts;

use ReflectionClass;

abstract class Enumerable
{
    protected $id;
    protected $name;
    protected $description;

    private static $instances = [];

    public function __construct($id, string $name, string $description = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;

        self::$instances[get_called_class()][$id] = $this;
    }

    public function id()
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    protected static function make(
        $id,
        string $name,
        string $description = ''
    ): Enumerable {
        $class = get_called_class();

        if (isset(self::$instances[$class][$id])) {
            return self::$instances[$class][$id];
        }

        $reflection = new ReflectionClass($class);

        $instance = $reflection->newInstance($id, $name, $description);


        return self::$instances[$class][$id] = $instance;
    }
}
