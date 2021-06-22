<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Processor;

use Hurtcode\Config\ConfigureException;

/**
 * Concatenate processor
 *
 * ---
 *
 * **!concatenate**
 *
 * Concatenate processor takes list of strings and sums it in one<br>
 * Tag rules:
 *  - value has to be array of string
 *
 * _Example:_
 * ```yaml
 *
 * !concatenate
 *   - some
 *   - string
 *   - is
 *
 * ```
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
final class ConcatenateProcessor extends AbstractTagProcessor
{
    /**
     * {@inheritdoc}
     */
    protected function validate(mixed $value): void
    {
        if (!is_array($value)) {
            throw new ConfigureException("Tag value has to be string!");
        }
        foreach ($value as $item) {
            if (!is_string($item)) {
                throw new ConfigureException("Array elements have to be string!");
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function do(mixed $value): mixed
    {
        return implode('', $value);
    }
}