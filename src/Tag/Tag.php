<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Tag;

use Hurtcode\Config\Yaml\Processor\{
    SubConfigurationProcessor,
    ConcatenateProcessor,
    EnvironmentProcessor,
    InterpretProcessor,
    CallableProcessor,
    VariableProcessor,
    MergeProcessor,
    GetProcessor,
};

/**
 * List of available tags
 *
 * This class contains of available tags needed
 * to create application configurations
 *
 * @package Hurtcode\Config\Yaml
 */
final class Tag
{
    /** @see CallableProcessor */
    public const CALLABLE = 'call';
    /** @see EnvironmentProcessor */
    public const ENV = 'env';
    /** @see ConcatenateProcessor */
    public const CONCATENATE = 'concatenate';
    /** @see MergeProcessor */
    public const MERGE = 'merge';
    /** @see InterpretProcessor */
    public const INTERPRET = 'interpret';
    /** @see SubConfigurationProcessor */
    public const SUB_CONF = 'sub';
    /** @see GetProcessor */
    public const GET = 'get';
    /** @see VariableProcessor */
    public const VARIABLE = 'var';
}