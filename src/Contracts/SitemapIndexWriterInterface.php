<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapIndexWriterInterface extends SitemapWriterInterface
{
    /**
     * Generates index and return file path with it.
     *
     * @param array<string> $files
     *
     * @return array<string>
     */
    public function generateIndex(array $files, string $outputDirectory, string $baseUrl): array;
}
