# Grav Ray Plugin

The **Grav Ray** Plugin is an extension for [Grav CMS](https://github.com/getgrav/grav). Grav plugin for the [Spatie Ray](https://myray.app/docs/getting-started/introduction) debugger app.

```php
ray('Hello world');

ray(['a' => 1, 'b' => 2])->color('red');

ray('multiple', 'arguments', 'are', 'welcome');
```

You of course, need to install the [standalone Ray debugger desktop app](https://myray.app/) or the free [Raygun CLI client](https://github.com/yetidevworks/raygun) for the plugin to function properly.

## Installation

Installing the Grav Ray plugin can be done in one of three ways: The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command, the manual method lets you do so via a zip file, and the admin method lets you do so via the Admin Plugin.

### GPM Installation (Preferred)

To install the plugin via the [GPM](https://learn.getgrav.org/cli-console/grav-cli-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install grav-ray

This will install the Grav Ray plugin into your `/user/plugins`-directory within Grav. Its files can be found under `/your/site/grav/user/plugins/grav-ray`.

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `grav-ray`. You can find these files on [GitHub](https://github.com/trilbymedia/grav-plugin-grav-ray) or via [GetGrav.org](https://getgrav.org/downloads/plugins).

You should now have all the plugin files under

    /your/site/grav/user/plugins/grav-ray
	
> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com/trilbymedia/grav-plugin-grav-ray/blob/main/blueprints.yaml).

### Admin Plugin

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins`-menu and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/grav-ray/grav-ray.yaml` to `user/config/plugins/grav-ray.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
host: 'localhost'
port: 23517
```

Note that if you use the Admin Plugin, a file with your configuration named grav-ray.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.

## Usage

Ray has many powerful methods that can be called via PHP. Check out the full docs for details: https://myray.app/docs/php/vanilla-php/reference

Twig helpers now return a proxy that mirrors the full Ray API, so you can chain advanced helpers directly in templates.

```twig
{# Twig function with multiple variables #}
{{ ray(page.header, uri.url) }}

{# Twig filter example #}
{{ page.header|ray }}

{# Fluent helpers are supported #}
{% do ray(page.title).blue().label('Page title') %}
{% do ray().image(page.media.images|first) %}
```

## Credits

Obviously this plugin would not exists if it wasn't for Spatie's Ray Debugger. Thanks to them for the license I used to test and develop this plugin..

