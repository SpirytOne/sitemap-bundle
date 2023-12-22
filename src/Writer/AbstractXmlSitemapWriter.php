<?php

namespace SpirytOne\SitemapBundle\Writer;

use SpirytOne\SitemapBundle\Contracts\SitemapInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapUrlInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapWriterInterface;
use SpirytOne\SitemapBundle\Contracts\SitemapExtension;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

abstract class AbstractXmlSitemapWriter implements SitemapWriterInterface
{
    private Filesystem $filesystem;
    private int $urlLimit = 40000;
    private bool $prettyPrint = true;

    public function setFilesystem(Filesystem $filesystem): self
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * @param string $filepath
     * @param array<SitemapExtension> $extensions
     *
     * @return \XMLWriter
     */
    protected function startXmlFile(string $filepath, array $extensions = []): \XMLWriter
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openUri($filepath);
        if ($this->prettyPrint) {
            $xmlWriter->setIndent(true);
            $xmlWriter->setIndentString('    ');
        }
        $xmlWriter->startDocument('1.0', 'UTF-8');
        $xmlWriter->startElementNs(null, 'urlset', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        if (in_array(SitemapExtension::VIDEO, $extensions, true)) {
            $this->addVideoExtension($xmlWriter);
        }

        if (in_array(SitemapExtension::NEWS, $extensions, true)) {
            $this->addNewsExtension($xmlWriter);
        }

        if (in_array(SitemapExtension::IMAGE, $extensions, true)) {
            $this->addImageExtension($xmlWriter);
        }

        if (in_array(SitemapExtension::XHTML, $extensions, true)) {
            $this->addXhtmlExtension($xmlWriter);
        }

        return $xmlWriter;
    }

    protected function closeXmlFile(\XMLWriter $xmlWriter): void
    {
        $xmlWriter->endElement();
        $xmlWriter->endDocument();
        $xmlWriter->flush();
    }

    protected function getTempfilePath(string $filename, int $number = 0): string
    {
        $filename = sprintf('%s_%d', $filename, $number);

        return $this->filesystem->tempnam(\sys_get_temp_dir(), $filename, '.xml');
    }

    protected function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    /**
     * @param array<string,array<string>> $sitemaps
     * @param string $targetDirectory
     *
     * @return array<string>
     */
    protected function moveFiles(array $sitemaps, string $targetDirectory): array
    {
        $output = [];
        foreach ($sitemaps as $collection => $files) {
            if (0 == count($files)) {
                continue;
            }

            if (1 == count($files)) {
                $target = Path::makeAbsolute(sprintf('%s.xml', $collection), $targetDirectory);
                $this->filesystem->rename($files[0], $target, true);
                $output[] = $target;
                continue;
            }

            foreach ($files as $id => $path) {
                $target = Path::makeAbsolute(sprintf('%s_%d.xml', $collection, $id), $targetDirectory);
                $this->filesystem->rename($path, $target, true);
                $output[] = $target;
            }
        }

        /** @psalm-suppress UnevaluatedCode */
        return $output;
    }

    protected function addUrl(\XMLWriter $xmlWriter, SitemapUrlInterface $url): void
    {
        $xmlWriter->startElement('url');

        $xmlWriter->startElement('loc');
        $xmlWriter->text(strtr($url->getLoc(), '\'', '&apos;'));
        $xmlWriter->endElement();

        if (($lastmod = $url->getLastmod()) instanceof \DateTimeInterface) {
            $xmlWriter->startElement('lastmod');
            $xmlWriter->text($lastmod->format('Y-m-d'));
            $xmlWriter->endElement();
        }

        if (($changefreq = $url->getChangefreq()) !== null) {
            $xmlWriter->startElement('changefreq');
            $xmlWriter->text($changefreq);
            $xmlWriter->endElement();
        }

        if (($priority = $url->getPriority()) !== null) {
            $xmlWriter->startElement('priority');
            $xmlWriter->text(sprintf('%.1f', $priority));
            $xmlWriter->endElement();
        }

        $xmlWriter->endElement();
    }

    protected function getUrlLimit(): int
    {
        return $this->urlLimit;
    }

    protected function setUrlLimit(int $limit): self
    {
        $this->urlLimit = $limit;

        return $this;
    }

    private function addVideoExtension(\XMLWriter $xmlWriter): void
    {
        $xmlWriter->writeAttributeNs('xmlns', 'video', null, 'http://www.google.com/schemas/sitemap-video/1.1');
    }

    private function addNewsExtension(\XMLWriter $xmlWriter): void
    {
        $xmlWriter->writeAttributeNs('xmlns', 'news', null, 'http://www.google.com/schemas/sitemap-news/0.9');
    }

    private function addImageExtension(\XMLWriter $xmlWriter): void
    {
        $xmlWriter->writeAttributeNs('xmlns', 'image', null, 'http://www.google.com/schemas/sitemap-image/1.1');
    }

    private function addXhtmlExtension(\XMLWriter $xmlWriter): void
    {
        $xmlWriter->writeAttributeNs('xmlns', 'xhtml', null, 'http://www.w3.org/1999/xhtml');
    }
}
