<?php

namespace SpirytOne\SitemapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SitemapPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('spirytone.sitemap_manager')) {
            return;
        }

        $manager = $container->findDefinition('spirytone.sitemap_manager');

        foreach ($container->findTaggedServiceIds('spirytone.sitemap') as $id => $tags) {
            $definition = $container->getDefinition($id);
            if ($definition->isAbstract()) {
                continue;
            }

            foreach ($tags as $tag) {
                $manager->addMethodCall('add', [new Reference($id), $tag['alias'] ?? null]);
            }
        }
    }
}
