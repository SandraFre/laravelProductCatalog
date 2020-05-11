<?php

declare(strict_types=1);

namespace App\Enum\Abstracts;

use Modules\Core\Exceptions\EnumNotFoundException;
use ReflectionClass;
use ReflectionMethod;

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

    public static function enum(): array
    {
        $reflection = new ReflectionClass(get_called_class());
        $finalMethods = $reflection->getMethods(ReflectionMethod::IS_FINAL);

        $return = [];
        foreach ($finalMethods as $method) {
            $enum = $method->invoke(null);
            $return[$enum->id()] = $enum;
        }

        return $return;
    }

    public static function options():array
    {
        return array_map(function(Enumerable $enumerable){
            return $enumerable->name();
        }, self::enum());
    }

    public static function from($id): Enumerable
    {
        $enum = self::enum();

        if (!isset($enum [$id])) {
            throw new EnumNotFoundException(strtr('Unable to find enumerable with :id of type :type', [
                ':id' =>$id,
                ':type' => get_called_class(),
            ]));
        }

        return $enum [$id];
    }

    public static function enumIds(): array
    {
        return array_keys(self::enum());
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
