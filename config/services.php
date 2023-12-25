<?php

use function Symfony\Component\DependencyInjection\Loader\Configurator\{service, param};
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use SpirytOne\SitemapBundle\Service\SitemapManager;
use SpirytOne\SitemapBundle\Writer;
use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;
use SpirytOne\SitemapBundle\Controller\SitemapIndexController;

return static function (ContainerConfigurator $container): void {
    $container->services()
        // Manager service
        ->set('spirytone.sitemap.manager', SitemapManager::class)
            ->public()
            ->alias(SitemapManager::class, 'spirytone.sitemap.manager')
            ->alias(SitemapManagerInterface::class, 'spirytone.sitemap.manager')

        // Abstract Split writer
        ->set('spirytone.sitemap.writer.abstract_split', Writer\SplitSitemapWriter::class)
            ->abstract()
            ->call('setUrlsLimit', [param('spirytone.sitemap.default_urls_limit')])
            ->tag('spirytone.sitemap.writer')


        // Abstract Continous writer
        ->set('spirytone.sitemap.writer.abstract_continuous', Writer\ContinuousSitemapWriter::class)
            ->abstract()
            ->call('setUrlsLimit', [param('spirytone.sitemap.default_urls_limit')])
            ->call('setPrettyPrint', [param('spirytone.sitemap.pretty_print')])
            ->tag('spirytone.sitemap.writer')

        // Writers
        ->set('spirytone.sitemap.writer.split')
            ->parent('spirytone.sitemap.writer.abstract_split')
            ->public()
            ->call('setFilesystem', [service('filesystem')])
            ->tag('spirytone.sitemap.writer', ['alias' => 'split'])

        ->set('spirytone.sitemap.writer.continuous')
            ->parent('spirytone.sitemap.writer.abstract_continuous')
            ->public()
            ->call('setFilesystem', [service('filesystem')])
            ->call('setPrettyPrint', [param('spirytone.sitemap.pretty_print')])
            ->tag('spirytone.sitemap.writer', ['alias' => 'continuous'])

        // Controllers
        ->set(SitemapIndexController::class)
            ->public()
            ->args([service('spirytone.sitemap.manager'), param('spirytone.sitemap.pretty_print')])
            ->tag('controller.service_arguments')
        ;
};
