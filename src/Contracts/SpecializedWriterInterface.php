<?php

namespace SpirytOne\SitemapBundle\Contracts;

interface SpecializedWriterInterface
{
    public function getWriter(): SitemapWriterInterface;
}
