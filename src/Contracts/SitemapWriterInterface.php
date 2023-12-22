<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapWriterInterface
{
    /**
     * Generate sitemaps and returns array of filepaths.
     *
     * @param array<SitemapInterface> $sitemaps
     *
     * @return array<string>
     */
    public function generate(array $sitemaps, string $outputDirectory): array;

    public function getName(): string;
}
