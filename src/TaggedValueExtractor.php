<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml;

use Symfony\Component\Yaml\Tag\TaggedValue;

/**
 * Tagged value extractor
 *
 * Class helpers. Extracts tagged value into array for multiply
 * assignment by `list()`
 *
 * @package Hurtcode\Config\Yaml\Tag
 */
final class TaggedValueExtractor
{
    private TaggedValue $taggedValue;

    /**
     * TaggedValueExtractor constructor
     *
     * @param TaggedValue $taggedValue
     */
    public function __construct(TaggedValue $taggedValue)
    {
        $this->taggedValue = $taggedValue;
    }

    /**
     * Extracts tagged value into tag and value
     *
     * @return array<string, string>
     */
    public function extract(): array
    {
        return [$this->taggedValue->getTag(), $this->taggedValue->getValue()];
    }
}