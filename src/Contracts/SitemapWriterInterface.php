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
     * Generate sitemaps and returns array of filepaths
     *
     * @return array
     */
    public function generate(string $outputDirectory, ?string $baseUrl = null): array;
}
