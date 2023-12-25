<?php

namespace SpirytOne\SitemapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;
use Symfony\Component\Finder\Finder;

class SitemapIndexController
{
    public function __construct(
        private SitemapManagerInterface $sitemapManager,
        private bool $prettyPrint = false,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $finder = new Finder();
        $baseUrl = $this->sitemapManager->getBaseUrl();
        if ((strlen($baseUrl) > 0) && ('/' !== substr($baseUrl, -1))) {
            $baseUrl = $baseUrl.'/';
        }

        $finder->files()
            ->name('*.xml')
            ->notName('sitemap_index.xml')
            ->in($this->sitemapManager->getOutputDirectory())
        ;

        $xml = new \XMLWriter();
        $xml->openMemory();
        if ($this->prettyPrint) {
            $xml->setIndent(true);
            $xml->setIndentString('    ');
        }
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElementNs(null, 'sitemapindex', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($finder as $file) {
            $xml->startElement('sitemap');
            $xml->startElement('loc');
            $xml->text(sprintf('%s%s', $baseUrl, $file->getFilename()));
            $xml->endElement();

            if (false !== ($lastmod = $file->getMTime())) {
                $xml->startElement('lastmod');
                /* @phpstan-ignore-next-line */
                $xml->text(\DateTime::createFromFormat('U', (string) $lastmod)->format(\DateTime::W3C));
                $xml->endElement();
            }
            $xml->endElement();
        }

        $xml->endElement();
        $xml->endDocument();

        $response = new Response();
        $response->headers->set('content-type', 'application/json; charset=UTF-8');
        $response->setContent($xml->outputMemory());

        return $response;
    }
}
