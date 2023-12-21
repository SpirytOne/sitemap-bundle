<?php

namespace SpirytOne\SitemapBundle\DependencyInjection;

use SpirytOne\SitemapBundle\Contracts\SitemapWriterInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;

final class SpirytOneSitemapExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.php');
        $loader->load('commands.php');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $manager = $container->getDefinition('spirytone.sitemap_manager');
        $this->setDefaultWriter($config['default_writer'], $container, $manager);
        $manager->addMethodCall('setOutputDirectory', [$config['default_output_directory']]);
        $manager->addMethodCall('setBaseUrl', [$config['default_base_url']]);
    }

    public function getAlias(): string
    {
        return 'spirytone_sitemap';
    }

    private function setDefaultWriter(string $name, ContainerBuilder $container, Definition $manager): void
    {
        $writers = $container->findTaggedServiceIds('spirytone.sitemap.writer');

        foreach ($writers as $id => $tags) {
            $writer = $container->getDefinition($id);
            if ($writer->isAbstract()) {
                continue;
            }

            foreach ($tags as $tag) {
                if ($tag['alias'] == $name) {
                    $manager->addMethodCall('setDefaultWriter', [new Reference($id)]);

                    $container->setAlias(SitemapWriterInterface::class, $id);
                    $container->setAlias('spirytone.sitemap.writer_default', $id);

                    return;
                }
            }
        }

        throw new \InvalidArgumentException(sprintf('Writer `%s` does not exists.', $name));
    }
}
