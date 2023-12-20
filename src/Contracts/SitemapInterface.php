<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapInterface
{
    public function getUrls(): iterable;

    public function getName(): string;
}
