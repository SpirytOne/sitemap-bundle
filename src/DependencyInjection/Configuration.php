<?php

namespace SpirytOne\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress UndefinedMethod
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('spirytone_sitemap');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('default_base_url')->defaultValue('%router.request_context.scheme%://%router.request_context.host%/sitemaps/')->end()
                ->scalarNode('default_output_directory')->defaultValue('%kernel.project_dir%/public/sitemaps')->end()
                ->integerNode('default_urls_limit')->defaultValue(40000)->end()
                ->scalarNode('default_writer')->defaultValue('split')->end()
                ->scalarNode('pretty_print')->defaultFalse()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
