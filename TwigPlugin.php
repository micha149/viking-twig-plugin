<?php

namespace Viking;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Viking\Plugin\Plugin;

/**
 * @fileoverview
 * @author   Michael van Engelshoven <michael@van-engelshoven.de>
 * @date     14.12.14 09:45
 * @license  All rights reserved.
 */

class TwigPlugin extends Plugin {


    /**
     * Loads a specific configuration.
     *
     * @param array $config An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configLoader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $configLoader->load('twig-plugin.yml');

        $twig = $container->getDefinition('templating.engine.twig.environment');

        foreach ($container->findTaggedServiceIds('twig.extension') as $id => $attributes) {
            $twig->addMethodCall('addExtension', array(new Reference($id)));
        }
    }
}