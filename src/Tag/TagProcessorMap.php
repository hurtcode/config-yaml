<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Tag;

use Hurtcode\Config\Yaml\Processor\{CallableProcessor,
    InterpretProcessor,
    MergeProcessor,
    SubConfigurationProcessor,
    VariableProcessor
};

/**
 * Tag processor map
 *
 * Maps tags to it's processors
 *
 * @see TagProcessorInterface
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
final class TagProcessorMap implements TagProcessorsMapInterface
{
    /**
     * {@inheritdoc}
     */
    public function map(): array
    {
        return [
            Tag::MERGE => MergeProcessor::class,
            Tag::SUB_CONF => SubConfigurationProcessor::class,
            Tag::INTERPRET => InterpretProcessor::class,
            Tag::VARIABLE => VariableProcessor::class,
            Tag::CALLABLE => CallableProcessor::class,
        ];
    }
}