<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Processor;

use Hurtcode\Config\ConfigureException;
use Throwable;

/**
 * Interpret processor
 *
 * ---
 *
 * **!interpret**
 *
 * This processor interprets incoming expression as php code. Be careful with this.
 * Incoming strings wraps by template `return {value};` and sends in `eval` function.<br>
 * Tag rules:
 *  - value has to be string
 *
 * Example:
 * ```yaml
 *
 * !interpret '$_SERVER['REQUEST_TIME']'
 *
 * ```
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
final class InterpretProcessor extends AbstractTagProcessor
{
    /**
     * {@inheritdoc}
     */
    protected function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new ConfigureException("Tag value has to be string!");
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function do(mixed $value): mixed
    {
        try {
            return eval("return $value;");
        } catch (Throwable $throwable) {
            throw new ConfigureException("Can't interpret incoming expression: $value!", $throwable->getCode(), $throwable);
        }
    }
}