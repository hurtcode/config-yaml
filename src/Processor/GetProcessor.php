<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Processor;

use Hurtcode\Config\ConfigureException;

/**
 * Get processor
 *
 * ---
 *
 * **!get**
 *
 * Get processor helps to get some curtain value from another configuration or list.
 * To use it you have to specify `key` (what you want) and `from` (where from need to get).<br>
 * Tag rules:
 *  - value has to be list with `key` and `from` keys.
 *  - `key` has to be string (for associative array) or int (for indexed array)
 *  - `from` has to be array or list
 *
 * Example:
 * ```yaml
 *
 * !get {key:element, from: {element: value}}
 *
 * ```
 *
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
final class GetProcessor extends AbstractTagProcessor
{

    /**
     * {@inheritdoc}
     */
    protected function validate(mixed $value): void
    {
        if (!isset($value['key']) && !isset($value['from'])) {
            throw new ConfigureException("Tag value has to contain 'key' and 'from'!");
        }
        if (!is_string($value['key']) && !is_int($value['key'])) {
            throw new ConfigureException("'key' has to be string or int!");
        }
        if (!is_array($value['from'])) {
            throw new ConfigureException("'from' has to be array!");
        }
        if (!isset($value['from'][$value['key']])) {
            throw new ConfigureException("Can't get {$value['key']} from list!");
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function do(mixed $value): mixed
    {
        return $value['from'][$value['key']];
    }
}