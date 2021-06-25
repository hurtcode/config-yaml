<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Processor;

use Hurtcode\Config\ConfigureException;
use yii\helpers\ArrayHelper;

/**
 * Callable processor
 *
 * ---
 *
 * **!call**
 *
 * Helps to call php function in configurations. Function name takes from `name` kay of tag's value
 * Also you can pass arguments, by `args` key<br>
 * Tag rules:
 *  - Value has to contain 'name' key.
 *  - 'name' has to be string
 *  - If you pass args as array it has to be indexed (without string keys)
 *
 * __Example:__
 * ```yaml
 *
 * !call
 *   name: substr
 *   args:
 *     - string
 *     - 0
 *     - 3
 *
 * ```
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
final class CallableProcessor extends AbstractTagProcessor
{
    /**
     * {@inheritdoc}
     */
    protected function validate(mixed $value): void
    {
        if (!isset($value['name'])) {
            throw new ConfigureException("Tag doesn't contain necessary values!");
        }
        if (!is_string($value['name'])) {
            throw new ConfigureException("Key name has to be string!");
        }
        if (
            isset($value['args']) &&
            is_array($value['args']) &&
            !ArrayHelper::isIndexed($value['args'])
        ) {
            throw new ConfigureException("Args has to be indexed array!");
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function do(mixed $value): mixed
    {
        $callable = $value['name'];
        $args = $value['args'] ?? null;
        try {
            return $this->call($callable, $args);
        } catch (\Throwable $t) {
            throw new ConfigureException(
                "Something gone wrong while calling function $callable. {$t->getMessage()}",
                $t->getCode(),
                $t
            );
        }
    }

    /**
     * Calls php function
     *
     * @param string $callable
     * @param string|array|null $args
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    private function call(string $callable, mixed $args): mixed
    {
        if (!isset($args)) {
            return $callable();
        }
        if (is_array($args)) {
            return $callable(...$args);
        }
        return $callable($args);
    }

}