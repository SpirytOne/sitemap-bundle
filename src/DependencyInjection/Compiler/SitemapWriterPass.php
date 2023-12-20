<?php

namespace SpirytOne\SitemapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SitemapWriterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('spirytone.sitemap_manager')) {
            return;
        }

        $manager = $container->findDefinition('spirytone.sitemap_manager');

        foreach ($container->findTaggedServiceIds('spirytone.sitemap.writer') as $id => $tags) {
            $definition = $container->getDefinition($id);
            if ($definition->isAbstract()) {
                continue;
            }

            foreach ($tags as $tag) {
                $manager->addMethodCall('addWriter', [$tag['name'], new Reference($id)]);
            }
        }
    }
}
