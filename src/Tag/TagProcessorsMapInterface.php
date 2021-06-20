<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Tag;

/**
 * Tag processor map interface
 *
 * Provides interface for mapping processors with curtain tag
 *
 * @package Hurtcode\Config\Yaml\Tag
 */
interface TagProcessorsMapInterface
{
    /**
     * Map of tag and processors
     *
     * Returns list of tags with theirs processors
     * ```php
     * [
     *   'someTag' => SomeTagProcessor::class
     * ]
     * ```
     *
     * @return array
     */
    public function map(): array;
}