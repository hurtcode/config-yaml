<?php

declare(strict_types=1);

namespace Hurtcode\Config\Yaml\Tag;

use Hurtcode\Config\ConfigureException;
use Psr\Container\ContainerInterface;
use Throwable;

/**
 * Tag processor context
 *
 * Runs curtain tag processing. Has strategy factory to
 * get needed processing algorithm
 *
 * @package Hurtcode\Config\Yaml\Tag
 */
final class AbstractTagProcessorFactory implements TagProcessorFactoryInterface
{
    private TagProcessorsMapInterface $map;
    private ?ContainerInterface $container;

    /**
     * AbstractTagProcessorFactory constructor
     *
     * @param TagProcessorsMapInterface $map
     * @param ContainerInterface|null $container
     */
    public function __construct(TagProcessorsMapInterface $map, ContainerInterface $container = null)
    {
        $this->map = $map;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessor(string $tag): TagProcessorInterface
    {
        if (!isset($this->map->map()[$tag])) {
            throw new ConfigureException("Can't find processor for tag $tag");
        }
        $processorClass = $this->map->map()[$tag];
        if ($this->canGetFromContainer($processorClass)) {
            return $this->container->get($processorClass);
        }
        try {
            return new $processorClass();
        } catch (Throwable $t) {
            throw new ConfigureException("$processorClass class instantiate error!", $t->getCode(), $t);
        }
    }

    /**
     * Checks if processor can be get from di container
     *
     * @param string $class
     *
     * @return bool
     */
    public function canGetFromContainer(string $class): bool
    {
        return isset($this->container) && $this->container->has($class);
    }
}