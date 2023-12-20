<?php

namespace SpirytOne\SitemapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use SpirytOne\SitemapBundle\Services\SitemapManager;

class SitemapPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('spirytone.sitemap_manager')) {
            return;
        }

        $definition = $container->findDefinition('spirytone.sitemap_manager');
        $taggedServices = $container->findTaggedServiceIds('spirytone.sitemap');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('add', [new Reference($id)]);
        }
    }
}
