<?php

namespace SpirytOne\SitemapBundle\Writer;

use SpirytOne\SitemapBundle\Contracts\SitemapWriterInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapInterface;

abstract class AbstractSitemapWriter implements SitemapWriterInterface
{
    private array $sitemaps = [];

    /**
     * @inheritdoc
     */
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
