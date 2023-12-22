<?php

namespace SpirytOne\SitemapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Attribute\AsController;

class SitemapIndexController
{
    public function __construct(
        private SitemapManagerInterface $sitemapManager
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $finder = new Finder();

        $sitemaps = [];
        $finder->files()
            ->name('*.xml')
            ->notName('sitemap_index.xml')
            ->in($this->sitemapManager->getOutputDirectory())
        ;

        foreach ($finder as $file) {
            // $sitemaps[] = $file->get
            var_dump($file);
        }

        return new Response();
    }
}
