<?php
namespace SpirytOne\SitemapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class SpirytOneSitemapBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new \SpirytOne\SitemapBundle\DependencyInjection\Compiler\SitemapPass());
        $container->addCompilerPass(new \SpirytOne\SitemapBundle\DependencyInjection\Compiler\SitemapWriterPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new \SpirytOne\SitemapBundle\DependencyInjection\SpirytOneSitemapExtension();
    }
}
