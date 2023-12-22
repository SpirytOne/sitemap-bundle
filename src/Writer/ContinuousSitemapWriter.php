<?php

namespace SpirytOne\SitemapBundle\Writer;

/**
 * ContinuousSitemapWriter write all sitemaps to one files.
 */
class ContinuousSitemapWriter extends AbstractXmlSitemapWriter
{
    public function generate(array $sitemaps, string $outputDirectory, string $baseUrl = null): array
    {
        $files = [];

        $extensions = [];
        foreach ($sitemaps as $sitemap) {
            $extensions = array_unique(array_merge($extensions, $sitemap->getExtensions()));
        }

        $filename = $this->getTempfilePath('sitemap');
        $xml = $this->startXmlFile($filename, $extensions);

        $urlsCount = 0;
        foreach ($sitemaps as $sitemap) {
            foreach ($sitemap->getUrls() as $url) {
                if ($urlsCount >= $this->getUrlsLimit()) {
                    $this->closeXmlFile($xml);
                    $files['sitemap'][] = $filename;
                    $filename = $this->getTempfilePath('sitemap', count($files['sitemap']));
                    $urlsCount = 0;

                    $xml = $this->startXmlFile($filename);
                }

                $this->addUrl($xml, $url);
                $urlsCount++;

                if (($urlsCount % 1000) == 0) {
                    $xml->flush();
                    \gc_collect_cycles();
                }
            }
        }

        $this->closeXmlFile($xml);
        if ($urlsCount > 0) {
            $files['sitemap'][] = $filename;
        }

        return $this->moveFiles($files, $outputDirectory);
    }

    public function getName(): string
    {
        return 'continuous';
    }
}
