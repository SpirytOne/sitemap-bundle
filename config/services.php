<?php

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use SpirytOne\SitemapBundle\Service\SitemapManager;
use SpirytOne\SitemapBundle\Writer;
use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        // Manager service
        ->set('spirytone.sitemap_manager', SitemapManager::class)
            ->public()
            ->alias(SitemapManager::class, 'spirytone.sitemap_manager')
            ->alias(SitemapManagerInterface::class, 'spirytone.sitemap_manager')

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
            ->public()
            ->call('setFilesystem', [service('filesystem')])
            ->tag('spirytone.sitemap.writer', ['alias' => 'split'])

        ->set('spirytone.sitemap.writer.continuous')
            ->parent('spirytone.sitemap.writer.abstract_continuous')
            ->public()
            ->call('setFilesystem', [service('filesystem')])
            ->tag('spirytone.sitemap.writer', ['alias' => 'continuous'])
        ;
};
