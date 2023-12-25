<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use SpirytOne\SitemapBundle\Controller\SitemapIndexController;

return function (RoutingConfigurator $routes): void {
    $routes->add('spirytone_sitemap_index', '/sitemap_index.{_format}')
        ->controller(SitemapIndexController::class)
        ->methods(['GET'])
        ->requirements(['_format' => 'xml'])
    ;
};
