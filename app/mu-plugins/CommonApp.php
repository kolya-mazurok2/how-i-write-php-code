<?php

namespace App;

/**
 * CommonApp Class
 *
 * This is an abstract class representing a singleton pattern.
 * It ensures that only one instance of any class derived from it can be created.
 *
 */
abstract class CommonApp
{
    /**
     * @var array $instances Holds the single instances of the child classes.
     */
    protected static array $instances = [];

    /**
     * CommonApp constructor.
     *
     * A protected constructor prevents direct instantiation of the class from outside.
     */
    protected function __construct()
    {
    }

    /**
     * Prevents the object from being cloned.
     */
    protected function __clone()
    {
    }

    /**
     * Overrides the __wakeup() method to prevent unserialization.
     *
     * @throws \Exception Throws an exception with the message "Cannot unserialize a singleton".
     */
    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize a singleton');
    }

    /**
     * Provides a static method to retrieve the singleton instance of the class.
     *
     * If an instance does not exist, it creates one.
     *
     * @return CommonApp The singleton instance of the class.
     */
    public static function getInstance(): CommonApp
    {
        $className = static::class;

        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static();
        }

        return self::$instances[$className];
    }

    /**
     * Initializes the common application.
     *
     * This method should be implemented by subclasses to perform specific initialization tasks.
     *
     * @return void
     */
    abstract public function initialize(): void;
}
