<?php

namespace SpirytOne\SitemapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SpirytOne\SitemapBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use SpirytOne\SitemapBundle\Service\SitemapManager;

final class SpirytOneSitemapExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.php');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // $definition = $container->getDefinition('spirytone.sitemap_manager');
        // $definition
        //     ->setArgument('$outputDir', $config['output_directory'])
        //     ->setArgument('$baseUrl', $config['default_uri'])
        // ;

        // $container->setParameter('spirytone.sitemap.urls_limit', $config['urls_limit']);
        // $container->setParameter('spirytone.sitemap.pretty_print', $config['pretty_print']);
    }

    public function getAlias(): string
    {
        return 'spirytone_sitemap';
    }
}
