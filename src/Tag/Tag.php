<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Tag;

use Hurtcode\Config\Yaml\Processor\CallableProcessor;
use Hurtcode\Config\Yaml\Processor\InterpretProcessor;
use Hurtcode\Config\Yaml\Processor\MergeProcessor;
use Hurtcode\Config\Yaml\Processor\SubConfigurationProcessor;
use Hurtcode\Config\Yaml\Processor\VariableProcessor;

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
    /**
     * Determines environment directory
     */
    public const ENV = 'env';
    /**
     * Indicates that next values will be concatenates in one
     * (works only with strings)
     */
    public const CONCATENATE = 'concatenate';
    /** @see MergeProcessor */
    public const MERGE = 'merge';
    /** @see InterpretProcessor */
    public const INTERPRET = 'interpret';
    /** @see SubConfigurationProcessor */
    public const SUB_CONF = 'sub';
    /**
     * This tag helps to get some value from array
     */
    public const GET = 'get';
    /** @see VariableProcessor */
    public const VARIABLE = 'var';
}