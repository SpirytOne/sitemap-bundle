<?php

namespace SpirytOne\SitemapBundle\Writer;

use SpirytOne\SitemapBundle\Contracts\SitemapInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapWriterInterface;

abstract class AbstractSitemapWriter implements SitemapWriterInterface
{
    /**
     * @var array<string,SitemapInterface>
     */
    private array $sitemaps = [];

    public function addSitemap(SitemapInterface $sitemap): self
    {
        $this->sitemaps[$sitemap->getName()] = $sitemap;

        return $this;
    }

    /**
     * @return array<string,SitemapInterface>
     */
    protected function getSitemaps(): array
    {
        return $this->sitemaps;
    }
}
