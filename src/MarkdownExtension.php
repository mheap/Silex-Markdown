<?php

namespace SilexMarkdown;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser;

use SilexMarkdown\MarkdownTwigExtension;

class MarkdownExtension implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['markdown'] = function () use ($app) {
            $features = isset($app['markdown.features']) ? $app['markdown.features'] : array();
            return new MarkdownParser($features);
        };

        if (isset($app['twig'])) {
            $app->extend('twig', function ($twig, $app) {
                $twig->addExtension(new MarkdownTwigExtension($app['markdown']));
                return $twig;
            });
        }
    }
}
