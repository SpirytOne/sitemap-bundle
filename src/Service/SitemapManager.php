<?php

namespace SpirytOne\SitemapBundle\Service;

use SpirytOne\SitemapBundle\Contracts\SitemapInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapWriterInterface;

class SitemapManager implements SitemapManagerInterface
{
    private array $sitemaps = [];
    private array $writers = [];

    private SitemapWriterInterface $defaultWriter;
    private string $outputDirectory;
    private string $baseUrl;

    public function add(SitemapInterface $sitemap): static
    {
        $this->sitemaps[$sitemap->getName()] = $sitemap;

        return $this;
    }

    public function generate(array $names = []): array
    {
        if (empty($names)) {
            $names = array_keys($this->sitemaps);
        } else {
            $diff = array_diff($names, array_keys($this->sitemaps));

            if (!empty($diff)) {
                throw new \LogicException(sprintf('Sitemaps `%s` does not exists!', join(', ', $diff)));
            }
        }

        // $files = [];
    }

    public function addWriter(string $name, SitemapWriterInterface $writer): self
    {
        $this->writers[$name] = $writer;

        return $this;
    }

    public function setDefaultWriter(SitemapWriterInterface $writer): self
    {
        $this->defaultWriter = $writer;

        return $this;
    }

    public function setOutputDirectory(string $outputDirectory): self
    {
        $this->outputDirectory = $outputDirectory;

        return $this;
    }

    public function getOutputDirectory(): string
    {
        return $this->outputDirectory;
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getSitemaps(): array
    {
        return $this->sitemaps;
    }

    public function getWriters(): array
    {
        return $this->writers;
    }
}
