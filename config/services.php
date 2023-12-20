<?php

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use SpirytOne\SitemapBundle\Service\SitemapManager;
use SpirytOne\SitemapBundle\Writer;

return static function (ContainerConfigurator $container): void {
    $container->services()
        // Manager service
        ->set('spirytone.sitemap_manager', SitemapManager::class)
            ->public(true)
            ->alias(SitemapManager::class, 'spirytone.sitemap_manager')

        // Split writer
        ->set('spirytone.sitemap.writer.abstract_split', Writer\SplitSitemapWriter::class)
            ->abstract()
            ->tag('spirytone.sitemap.writer')

        // Continous writer
        ->set('spirytone.sitemap.writer.abstract_continuous', Writer\ContinuousSitemapWriter::class)
            ->abstract()
            ->tag('spirytone.sitemap.writer')

        ->set('spirytone.sitemap.writer.split')
            ->parent('spirytone.sitemap.writer.abstract_split')
            ->public(true)
            ->tag('spirytone.sitemap.writer', ['name' => 'split'])

        ->set('spirytone.sitemap.writer.continuous')
            ->parent('spirytone.sitemap.writer.abstract_continuous')
            ->public(true)
            ->tag('spirytone.sitemap.writer', ['name' => 'continuous'])
        ;
};
