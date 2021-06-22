<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Processor;

use Hurtcode\Config\ConfigureException;

/**
 * Variable processor
 *
 * ---
 *
 * **!var**
 *
 * This processor provides ability to create global configuration variables in yaml.
 * It has two work modes: 1) Set mode; 2) Get mode.<br>
 * Tag rules:
 *  - Value has to contain `key` and `value` (IF YOU WANT SET)
 *  - `Key` has to be string (ONLY SET MODE)
 *  - Value has to be string.
 *  - Value has to be in 'container'. It means you has to set variable before call it!.
 *
 * _Example:_
 * ```yaml
 *
 * !var {set: variable, value: some value'}
 * .
 * .
 * !var variable
 *
 * ```
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
final class VariableProcessor extends AbstractTagProcessor
{
    /** Key for 'key' of value will be set */
    private const KEY = 'key';
    /** Key for value will be set */
    private const VALUE = 'value';

    /**
     * Container for variables
     * @var array
     */
    private static array $container;

    /**
     * {@inheritdoc}
     */
    public function process(mixed $value): mixed
    {
        if ($this->isSetMode($value)) {
            $this->setValue($value);
            return $value[self::VALUE];
        }
        return parent::process($value);
    }

    /**
     * Checks if tag used to set value
     *
     * @param mixed $value
     *
     * @return bool
     */
    private function isSetMode(mixed $value): bool
    {
        return is_array($value)
            && isset($value[self::KEY])
            && isset($value[self::VALUE]);
    }

    /**
     * Sets value in container
     *
     * @param $value
     *
     * @throws ConfigureException
     */
    private function setValue($value): void
    {
        list($key, $value) = [$value[self::KEY], $value['value']];
        if (!is_string($key)) {
            throw new ConfigureException("Key for value has to be string");
        }
        self::$container[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new ConfigureException("Tag value has to be string!");
        }
        if (!isset(self::$container[$value])) {
            throw new ConfigureException(ucfirst($value) . " isn't exist in container!");
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function do(mixed $value): mixed
    {
        return self::$container[$value];
    }
}