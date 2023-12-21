<?php

namespace SpirytOne\SitemapBundle\Writer;

/**
 * ContinuousSitemapWriter write all sitemaps to one files.
 */
class ContinuousSitemapWriter extends AbstractXmlSitemapWriter
{
    public function generate(array $sitemaps, string $outputDirectory, string $baseUrl = null): array
    {
        //
    }

    public function getName(): string
    {
        return 'continuous';
    }
}
