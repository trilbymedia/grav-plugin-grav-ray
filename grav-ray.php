<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Spatie\Ray\Client;
use Spatie\Ray\PayloadFactory;
use Spatie\Ray\Ray;
use Spatie\Ray\Settings\SettingsFactory;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class GravRayPlugin
 * @package Grav\Plugin
 */
class GravRayPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => [
                // Uncomment following line when plugin requires Grav < 1.7
                // ['autoload', 100000],
                ['onPluginsInitialized', 0]
            ]
        ];
    }

    /**
     * Composer autoload
     *
     * @return ClassLoader
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized(): void
    {
        // Enable the main events we are interested in
        $this->enable([
            'onTwigInitialized' => ['onTwigInitialized', 0]
        ]);

        $options = $this->config();
        $client = new Client($options['port'], $options['host']);
        Ray::create($client);
    }

    public function onTwigInitialized(): void
    {
        $this->grav['twig']->twig()->addFunction(
            new TwigFunction('ray', [$this, 'gray_ray'])
        );
        $this->grav['twig']->twig()->addFilter(
            new TwigFilter('ray', [$this, 'gray_ray'])
        );
    }

    public function gray_ray(...$args): string
    {
        ray(...$args);
        return '';
    }
}
