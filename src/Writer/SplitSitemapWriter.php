<?php

namespace SpirytOne\SitemapBundle\Writer;

use SpirytOne\SitemapBundle\SitemapWriterInterface;

/**
 * DefaultSitemapWriter write each sitemap to separate file (sitemap_<name of sitemap>)
 */
class SplitSitemapWriter extends AbstractWriter
{
    /**
     * @inheritdoc
     */
    public function generate(): array
    {
        //
    }
}
