<?php

namespace SpirytOne\SitemapBundle\Writer;

use SpirytOne\SitemapBundle\SitemapWriterInterface;

/**
 * ContinuousSitemapWriter write all sitemaps to one files
 */
class ContinuousSitemapWriter extends AbstractSitemapWriter
{
    /**
     * @inheritdoc
     */
    public function generate(string $outputDirectory, ?string $baseUrl = null): array
    {
        //
    }
}
