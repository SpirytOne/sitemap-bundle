<?php

namespace SpirytOne\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('spirytone_sitemap');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('default_uri')->defaultValue('%router.request_context.scheme%://%router.request_context.host%/sitemaps/')->end()
                ->scalarNode('default_output_directory')->defaultValue('%kernel.project_dir%/public/sitemaps')->end()
                ->integerNode('default_urls_limit')->defaultValue(40000)->end()
                ->scalarNode('default_writer')->defaultValue('default')->end()
                ->arrayNode('writers')
                    ->useAttributeAsKey('name')
                    ->requiresAtLeastOneElement()
                    ->arrayPrototype()
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('writer')->end()
                            ->scalarNode('output_directory')->defaultNull()->end()
                            ->integerNode('urls_limit')->defaultNull()->end()
                            ->booleanNode('pretty_print')->defaultFalse()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
