<?php

namespace SpirytOne\SitemapBundle\Writer;

use SpirytOne\SitemapBundle\SitemapWriterInterface;

/**
 * DefaultSitemapWriter write each sitemap to separate file (sitemap_<name of sitemap>)
 */
class SplitSitemapWriter extends AbstractSitemapWriter
{
    /**
     * @inheritdoc
     */
    public function generate(string $outputDirectory, ?string $baseUrl = null): array
    {
        //
    }
}
