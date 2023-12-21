<?php

namespace SpirytOne\SitemapBundle\Contracts;

enum SitemapExtension {
    case VIDEO;
    case NEWS;
    case IMAGE;
    case XHTML; // Hreflang
}
