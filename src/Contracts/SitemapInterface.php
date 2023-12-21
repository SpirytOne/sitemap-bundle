<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapInterface
{
    /**
     * @return array<SitemapUrlInterface>
     */
    public function getUrls(): iterable;

    public function getName(): string;

    /**
     * @return array<SitemapExtension>
     */
    public function getExtensions(): array;
}
