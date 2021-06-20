<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Tag;

use Hurtcode\Config\ConfigureException;

/**
 * Tag processor
 *
 * This interface describes tag parsing algorithm. Helps to create specific logic of
 * yaml tag processing
 *
 * @package Hurtcode\Config\Yaml\Tag
 */
interface TagProcessorInterface
{
    /**
     * Processes tag's value
     *
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws ConfigureException
     */
    public function process(mixed $value): mixed;
}