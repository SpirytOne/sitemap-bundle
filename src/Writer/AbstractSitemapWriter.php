<?php

namespace SpirytOne\SitemapBundle\Writer;

use SpirytOne\SitemapBundle\Contracts\SitemapInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapWriterInterface;

abstract class AbstractSitemapWriter implements SitemapWriterInterface
{
    private array $sitemaps = [];

    public function addSitemap(SitemapInterface $sitemap): static
    {
        $this->sitemaps[$sitemap->getName()] = $sitemap;

        return $this;
    }

    protected function getSitemaps(): array
    {
        return $this->sitemaps;
    }
}
