<?php

namespace SpirytOne\SitemapBundle\Writer;

use SpirytOne\SitemapBundle\Contracts\SitemapExtension;

/**
 * SplitSitemapWriter write each sitemap to separate file (sitemap_<name of sitemap>).
 */
class SplitSitemapWriter extends AbstractXmlSitemapWriter
{
    /**
     * @inheritdoc
     */
    public function generate(array $sitemaps, string $outputDirectory, string $baseUrl = null): array
    {
        $files = [];
        foreach ($sitemaps as $sitemap) {
            $basename = sprintf('sitemap_%s', $sitemap->getName());
            $filename = $this->getTempfilePath($basename);
            $files[$basename][] = $filename;

            // add urls

            $xml = $this->startXmlFile($filename, [SitemapExtension::VIDEO, SitemapExtension::NEWS, SitemapExtension::IMAGE, SitemapExtension::XHTML]);//$sitemap->getExtensions());
            $this->closeXmlFile($xml);
        }

        return $this->moveFiles($files, $outputDirectory);
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'split';
    }
}
