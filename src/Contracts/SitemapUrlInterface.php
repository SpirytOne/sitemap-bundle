<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SitemapUrlInterface
{
    public function getLoc(): string;
    public function getLastmod(): ?\DateTimeInterface;
    public function getChangefreq(): ?string;
    public function getPriority(): ?float;
}
