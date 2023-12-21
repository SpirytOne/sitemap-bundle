<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapManagerInterface
{
    public function generate(array $names = []): array;
    public function getOutputDirectory(): string;
    public function getBaseUrl(): string;
    public function getSitemaps(): array;
    public function getWriters(): array;
}
