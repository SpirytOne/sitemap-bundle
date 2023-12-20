<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapWriterInterface
{
    /**
     * Add sitemaps to generate
     *
     * @return self
     */
    public function addSitemap(SitemapInterface $sitemap): self;

    /**
     * Generate and saves files
     *
     * @return array<string> List of path of generated files
     */
    public function generate(): array;
}
