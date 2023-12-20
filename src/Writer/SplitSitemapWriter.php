<?php

namespace SpirytOne\SitemapBundle\Writer;

/**
 * DefaultSitemapWriter write each sitemap to separate file (sitemap_<name of sitemap>).
 */
class SplitSitemapWriter extends AbstractSitemapWriter
{
    public function generate(string $outputDirectory, string $baseUrl = null): array
    {
    }
}
