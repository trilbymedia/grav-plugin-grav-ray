<?php

namespace Grav\Plugin\GravRay;

use Spatie\Backtrace\Frame;
use Spatie\Ray\Origin\DefaultOriginFactory;

/**
 * Custom Ray origin factory that skips frames inside the Grav Ray plugin.
 */
class TwigOriginFactory extends DefaultOriginFactory
{
    /**
     * Determine the origin frame while ignoring the plugin proxy frames.
     */
    protected function getFrame()
    {
        $frames = $this->getAllFrames();
        $index = $this->getIndexOfRayFrame($frames);

        if ($index === null) {
            return null;
        }

        foreach (array_slice($frames, $index) as $frame) {
            if ($this->shouldSkipFrame($frame)) {
                continue;
            }

            return $frame;
        }

        return $frames[$index] ?? null;
    }

    /**
     * Skip frames that originate from the Grav Ray plugin, Grav core, or vendor code.
     */
    protected function shouldSkipFrame(Frame $frame): bool
    {
        $class = $frame->class ?? '';
        $file = $frame->file ?? '';

        if ($class !== '' && strpos($class, __NAMESPACE__ . '\\') === 0) {
            return true;
        }

        if ($file === '') {
            return true;
        }

        if (strpos($file, 'user/plugins/grav-ray') !== false) {
            return true;
        }

        if ($this->pathContains($file, '/vendor/')) {
            return true;
        }

        if ($this->pathContains($file, '/system/')) {
            return true;
        }

        return false;
    }

    protected function pathContains(string $path, string $needle): bool
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            $path = str_replace('\\', '/', $path);
        }

        return strpos($path, $needle) !== false;
    }
}
