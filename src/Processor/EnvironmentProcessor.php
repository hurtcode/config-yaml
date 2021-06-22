<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Processor;

use Hurtcode\Config\{Configurator, ConfigureException};

/**
 * Environment processor
 *
 * ---
 *
 * **!env**
 *
 * This processor takes configuration of from environment directory and
 * compiles it like sub configuration processor. Environment directory can
 * be passed from di container. By default environment is 'dev'.<br>
 * Tag rules:
 *  - Value has to be string
 *
 * _Example:_
 * ```yaml
 *
 * !env config
 *
 * ```
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
final class EnvironmentProcessor extends AbstractTagProcessor
{
    /**
     * System environment
     * @var string
     */
    private string $env;

    /**
     * EnvironmentProcessor constructor
     *
     * @param string $env
     */
    public function __construct(string $env = 'dev')
    {
        $this->env = $env;
    }

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
            Configurator::$locator->config()->sub("{$this->env}/$value")
        );
    }
}