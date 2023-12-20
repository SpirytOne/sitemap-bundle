<?php

namespace SpirytOne\SitemapBundle\Service;

use SpirytOne\SitemapBundle\Contracts\SitemapInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapWriterInterface;

class SitemapManager
{
    private array $sitemaps = [];
    private array $writers = [];

    public function add(SitemapInterface $sitemap): static
    {
        $this->sitemaps[$sitemap->getName()] = $sitemap;

        return self;
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

        //
    }

    public function addWriter(string $name, SitemapWriterInterface $writer): static
    {
        $this->writers[$name] = $writer;

        return self;
    }
}
