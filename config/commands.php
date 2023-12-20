<?php

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;
use SpirytOne\SitemapBundle\Command\GenerateCommand;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('spirytone.sitemap.command.generate', GenerateCommand::class)
        ->args([service('spirytone.sitemap_manager')])
        ->tag('console.command', ['command' => 'spirytone:sitemap:generate'])
    ;
};
