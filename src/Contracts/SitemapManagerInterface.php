<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapManagerInterface
{
    /**
     * Generates sitemap files.
     *
     * @param array<string> $names
     *
     * @return array<int,string>
     */
    public function generate(array $names = []): array;
    public function getOutputDirectory(): string;
    public function getBaseUrl(): string;

    /**
     * Returns all registered sitemaps
     *
     * @return array<string,SitemapInterface>
     */
    public function getSitemaps(): array;

    /**
     * Returns all registered writers
     *
     * @return array<string,SitemapWriterInterface>
     */
    public function getWriters(): array;
}
