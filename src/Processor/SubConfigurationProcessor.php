<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Processor;

use Hurtcode\Config\Configurator;
use Hurtcode\Config\ConfigureException;

/**
 * Sub configuration processor
 *
 * ---
 *
 * **!sub**
 *
 * This processor compiles new configuration and returns it in
 * place where the tag has been used. The configuration file path is relative to the
 * path to the configuration folder<br>
 * Tag rules:
 *  - Value has to be string
 *
 * _Example:_
 * ```yaml
 *
 * !sub path/in/depth/file
 *
 * ```
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
final class SubConfigurationProcessor extends AbstractTagProcessor
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
        return Configurator::$locator->compiler()->compile(
            Configurator::$locator->config()->sub($value)
        );
    }
}