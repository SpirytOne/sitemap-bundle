<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapWriterInterface
{
    /**
     * Add sitemaps to generate.
     */
    public function addSitemap(SitemapInterface $sitemap): self;

    /**
     * Generate sitemaps and returns array of filepaths.
     */
    public function generate(string $outputDirectory, string $baseUrl = null): array;
}
