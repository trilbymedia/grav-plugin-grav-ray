<?php

namespace Grav\Plugin\GravRay;

use Spatie\Ray\Ray;

/**
 * Thin wrapper around Spatie\Ray\Ray to preserve fluent calls in Twig.
 */
class TwigRayProxy
{
    /** @var Ray */
    private $ray;

    public function __construct(Ray $ray)
    {
        $this->ray = $ray;
    }

    /**
     * Proxy unknown method calls to the underlying Ray instance.
     *
     * Twig treats most Ray helpers as side effects. When the proxied method
     * returns a Ray instance we return the proxy again so chains continue to work.
     * Otherwise we bubble the return value up so helpers like counterValue()
     * behave the same as in PHP.
     */
    public function __call(string $name, array $arguments)
    {
        $result = $this->ray->$name(...$arguments);

        return $result instanceof Ray ? $this : $result;
    }

    /**
     * Allow Twig to render the proxy without visible output.
     */
    public function __toString(): string
    {
        return '';
    }

    public function ray(): Ray
    {
        return $this->ray;
    }
}
