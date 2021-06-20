<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Processor;

use Hurtcode\Config\ConfigureException;
use Yiisoft\Arrays\ArrayHelper;

/**
 * Merge tag processor
 *
 * ---
 *
 * **!merge**
 *
 * Merges tag values in one array. Uses Yiisoft/ArrayHelper.<br>
 * Tag rules:
 *  - tag value has to be array or list
 *  - tag has to contain at list 2 element
 *  - each element has be array or list
 *
 * Example:
 * ```yaml
 *
 * !merge
 *   - [some value, another value]
 *   - {key: value, anotherKey: another value}
 *
 * ```
 *
 * @see ArrayHelper
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
final class MergeProcessor extends AbstractTagProcessor
{
    /**
     * {@inheritdoc}
     */
    protected function validate(mixed $value): void
    {
        if (!is_array($value)) {
            $type = gettype($value);
            throw new ConfigureException("Tag value has to be array: $type is given!");
        }
        if (!(count($value) > 1)) {
            throw new ConfigureException("Merge tag has to contain at least 2 elements in its value!");
        }
        foreach ($value as $item) {
            if (!is_array($item)) {
                throw new ConfigureException("Tag items has to be array!");
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function do(mixed $value): mixed
    {
        return ArrayHelper::merge(...$value);
    }
}