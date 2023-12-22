<?php

namespace SpirytOne\SitemapBundle\Service;

use SpirytOne\SitemapBundle\Contracts\SitemapIndexWriterInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapWriterInterface;

/** @psalm-suppress MissingConstructor */
class SitemapManager implements SitemapManagerInterface
{
    /**
     * @var array<string,SitemapInterface>
     */
    private array $sitemaps = [];

    /**
     * @var array<string,SitemapWriterInterface>
     */
    private array $writers = [];

    /** @phpstan-ignore-next-line */
    private SitemapWriterInterface $defaultWriter;

    /** @phpstan-ignore-next-line */
    private string $outputDirectory;

    /** @phpstan-ignore-next-line */
    private string $baseUrl;

    public function add(SitemapInterface $sitemap): static
    {
        $this->sitemaps[$sitemap->getName()] = $sitemap;

        return $this;
    }

    public function generate(array $names, string $outputDirectory = null, bool $withIndex = false, string $baseUrl = null): array
    {
        if (0 == count($names)) {
            $names = array_keys($this->sitemaps);
        } else {
            $diff = array_diff($names, array_keys($this->sitemaps));

            if (count($diff) > 0) {
                throw new \LogicException(sprintf('Sitemaps `%s` does not exists!', join(', ', $diff)));
            }
        }

        $sitemaps = [];
        foreach ($names as $name) {
            $sitemaps[$name] = $this->sitemaps[$name];
        }

        $files = $this->defaultWriter->generate($sitemaps, $outputDirectory ?? $this->outputDirectory);

        if ($withIndex && ($this->defaultWriter instanceof SitemapIndexWriterInterface)) {
            $index = $this->defaultWriter->generateIndex($files, $outputDirectory ?? $this->outputDirectory, $baseUrl ?? $this->baseUrl);

            $files = array_merge($files, $index);
        }

        return $files;
    }

    public function addWriter(SitemapWriterInterface $writer, string $alias = null): static
    {
        $this->writers[$alias ?? $writer->getName()] = $writer;

        return $this;
    }

    public function setDefaultWriter(SitemapWriterInterface $writer): static
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
