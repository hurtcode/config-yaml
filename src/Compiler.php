<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml;

use Hurtcode\Config\CompilerInterface;
use Hurtcode\Config\ConfigureException;
use Hurtcode\Config\Yaml\Tag\TagProcessorFactoryInterface;
use Symfony\Component\Yaml\{Tag\TaggedValue, Yaml};

/**
 * Compiler
 *
 * This class compiles yaml configuration files. It uses symfony's
 * yaml parses and provides ability to fork with custom tags.
 * Each custom tag can be parsed by special processor [[TagProcessorInterface]].
 *
 * @package Hurtcode\Config\Yaml
 */
final class Compiler implements CompilerInterface
{
    /** @var TagProcessorFactoryInterface */
    private TagProcessorFactoryInterface $factory;

    /**
     * Compiler constructor.
     */
    public function __construct(TagProcessorFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function compile(string $data): array
    {
        $data = Yaml::parse($data, Yaml::PARSE_CUSTOM_TAGS);
        if (is_array($data)) {
            $out = $this->compileInDepth($data);
        } elseif ($data instanceof TaggedValue) {
            $out = $this->processTaggedValue($data);
            if (!is_array($out)) {
                $out[] = $out;
            }
        }
        return $out ?? [];
    }

    /**
     * Makes deep compilation
     *
     * Goes through every element in array and it's elements
     * to compile nested configurations
     *
     * @param array $data
     *
     * @return array
     *
     * @throws ConfigureException
     */
    private function compileInDepth(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $out[$key] = $this->compileInDepth($value);
            } elseif ($value instanceof TaggedValue) {
                $out[$key] = $this->processTaggedValue($value);
            } else {
                $out[$key] = $value;
            }
        }
        return $out ?? [];
    }

    /**
     * Processes tagged value
     *
     * Extracts tag and value from tagged value and uses factory to
     * process them.
     *
     * @param TaggedValue $taggedValue
     *
     * @return mixed
     *
     * @throws ConfigureException
     */
    private function processTaggedValue(TaggedValue $taggedValue): mixed
    {
        list($tag, $value) = (new TaggedValueExtractor($taggedValue))->extract();
        $value = $this->prepareValue($value);
        return $this->factory->getProcessor($tag)->process($value);
    }

    /**
     * Prepares value for processor
     *
     * Goes in depth through value to process nested
     * tagged value
     *
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws ConfigureException
     */
    private function prepareValue(mixed $value): mixed
    {
        if (is_array($value)) {
            foreach ($value as &$element) {
                $element = $this->prepareValue($element);
            }
        } elseif ($value instanceof TaggedValue) {
            $value = $this->processTaggedValue($value);
        }
        return $value;
    }
}