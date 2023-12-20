<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapWriterInterface
{
    /**
     * Add sitemaps to generate
     *
     * @return static
     */
    public function addSitemap(SitemapInterface $sitemap): static;

    /**
     * Generate and saves files
     *
     * @return array<string> List of path of generated files
     */
    public function generate(): array;
}
