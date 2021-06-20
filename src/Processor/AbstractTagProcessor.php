<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Processor;

use Hurtcode\Config\ConfigureException;
use Hurtcode\Config\Yaml\Tag\TagProcessorInterface;

/**
 * Abstract tag processor
 *
 * Implements tag processor method with to function:
 *  - validate() - runs input value validation
 *  - do() - runs processing
 *
 * @package Hurtcode\Config\Yaml\Processor
 */
abstract class AbstractTagProcessor implements TagProcessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(mixed $value): mixed
    {
        $this->validate($value);
        return $this->do($value);
    }

    /**
     * Validates incoming value
     *
     * @param mixed $value
     *
     * @throws ConfigureException
     * Throws exception if value isn't valid
     */
    protected function validate(mixed $value): void
    {
        return;
    }

    /**
     * Processing action
     *
     * This function runs tag processing
     *
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws ConfigureException
     */
    abstract protected function do(mixed $value): mixed;
}