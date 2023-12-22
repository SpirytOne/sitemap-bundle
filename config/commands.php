<?php

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;
use SpirytOne\SitemapBundle\Command as Commands;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('spirytone.sitemap.command.generate', Commands\GenerateCommand::class)
            ->args([service('spirytone.sitemap.manager')])
            ->tag('console.command', ['command' => 'spirytone:sitemap:generate'])

        ->set('spirytone.sitemap.command.list', Commands\ListCommand::class)
            ->args([service('spirytone.sitemap.manager')])
            ->tag('console.command', ['command' => 'spirytone:sitemap:list'])

        ->set('spirytone.sitemap.command.writer.list', Commands\WriterListCommand::class)
            ->args([service('spirytone.sitemap.manager')])
            ->tag('console.command', ['command' => 'spirytone:sitemap:writer-list'])
    ;
};
