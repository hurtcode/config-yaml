<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Tag;

use Hurtcode\Config\ConfigureException;

/**
 * Tag processor factory interface
 *
 * Factory produce processor for different tags.
 *
 * @package Hurtcode\Config\Yaml\Tag
 */
interface TagProcessorFactoryInterface
{
    /**
     * Creates processor for certain tag
     *
     * @param string $tag
     * Name of tag
     *
     * @return TagProcessorInterface
     *
     * @throws ConfigureException
     */
    public function getProcessor(string $tag): TagProcessorInterface;
}