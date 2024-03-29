<?php

namespace SpirytOne\SitemapBundle\Command;

use SpirytOne\SitemapBundle\Contracts\SitemapManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateCommand extends Command
{
    public function __construct(
        private SitemapManagerInterface $sitemapManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generate sitemaps')
            ->addArgument('name', InputArgument::IS_ARRAY, 'Name(s) of sitemap', [])
            ->addOption('output-dir', 'o', InputOption::VALUE_OPTIONAL, 'Output directory', $this->sitemapManager->getOutputDirectory())
            ->addOption('base-url', 'u', InputOption::VALUE_OPTIONAL, 'Base url used in sitemap index', $this->sitemapManager->getBaseUrl())
            ->addOption('with-index', 'i', InputOption::VALUE_NEGATABLE, 'Generate sitemap index file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $names = $input->getArgument('name');
        $baseUrl = $input->getOption('base-url');
        $outputDirectory = $input->getOption('output-dir');
        $withIndex = (bool) $input->getOption('with-index');

        $io->title('Generate sitemap');

        /** @phpstan-ignore-next-line */
        $files = $this->sitemapManager->generate($names, $outputDirectory, $withIndex, $baseUrl);

        $io->listing($files);

        return Command::SUCCESS;
    }
}
