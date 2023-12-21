<?php

namespace SpirytOne\SitemapBundle\Command;

use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListCommand extends Command
{
    public function __construct(
        private SitemapManagerInterface $sitemapManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('List available sitemaps')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $sitemaps = $this->sitemapManager->getSitemaps();
        $table = [];
        foreach ($sitemaps as $name => $sitemap) {
            $table[] = [$name, $sitemap::class];
        }

        $io->title('Sitemaps');
        $io->table(['Name/Alias', 'Class'], $table);

        return Command::SUCCESS;
    }
}
