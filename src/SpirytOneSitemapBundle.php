<?php

namespace SpirytOne\SitemapBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SpirytOneSitemapBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new \SpirytOne\SitemapBundle\DependencyInjection\Compiler\SitemapPass());
        $container->addCompilerPass(new \SpirytOne\SitemapBundle\DependencyInjection\Compiler\SitemapWriterPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new \SpirytOne\SitemapBundle\DependencyInjection\SpirytOneSitemapExtension();
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
