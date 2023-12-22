<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapManagerInterface
{
    /**
     * Generates sitemap files.
     *
     * @param array<string> $names
     * @param string        $outputDirectory
     * @param string        $baseUrl
     *
     * @return array<string>
     */
    public function generate(array $names, string $outputDirectory = null, bool $withIndex = false, string $baseUrl = null): array;

    public function getOutputDirectory(): string;

    public function getBaseUrl(): string;

    public function add(SitemapInterface $sitemap): static;

    public function addWriter(SitemapWriterInterface $writer, string $alias = null): static;

    public function setDefaultWriter(SitemapWriterInterface $writer): static;

    /**
     * Returns all registered sitemaps.
     *
     * @return array<string,SitemapInterface>
     */
    public function getSitemaps(): array;

    /**
     * Returns all registered writers.
     *
     * @return array<string,SitemapWriterInterface>
     */
    public function getWriters(): array;
}
