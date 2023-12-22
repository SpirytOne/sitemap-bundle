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
    public function generate(array $sitemaps, string $outputDirectory): array
    {
        $files = [];
        foreach ($sitemaps as $sitemap) {
            $basename = sprintf('sitemap_%s', $sitemap->getName());
            $filename = $this->getTempfilePath($basename);
            $xml = $this->startXmlFile($filename, $sitemap->getExtensions());

            $urlsCount = 0;
            foreach ($sitemap->getUrls() as $url) {
                if ($urlsCount >= $this->getUrlsLimit()) {
                    $this->closeXmlFile($xml);
                    $files[$basename][] = $filename;
                    $filename = $this->getTempfilePath($basename, count($files[$basename]));
                    $urlsCount = 0;

                    $xml = $this->startXmlFile($filename, $sitemap->getExtensions());
                }

                $this->addUrl($xml, $url);
                $urlsCount++;

                if (($urlsCount % 1000) == 0) {
                    $xml->flush();
                    \gc_collect_cycles();
                }
            }

            if ($urlsCount > 0) {
                $files[$basename][] = $filename;
            }

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
