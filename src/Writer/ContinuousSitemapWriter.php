<?php

namespace SpirytOne\SitemapBundle\Writer;

/**
 * ContinuousSitemapWriter write all sitemaps to one files.
 */
class ContinuousSitemapWriter extends AbstractSitemapWriter
{
    public function generate(string $outputDirectory, string $baseUrl = null): array
    {
    }

    public function getName(): string
    {
        return 'continuous';
    }
}
