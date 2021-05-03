<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class ListThemesCommand extends Command
{
    protected static $defaultName = 'list-themes';

    protected function configure(): void
    {
        $this->setDescription('List available themes');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $finder = new Finder();
        $finder->directories()->in(__DIR__ . '/resources/twig');

        $output->writeln("Available themes:");
        foreach ($finder as $file) {
            $output->writeln(' - ' . $file->getBasename());
        }
        $output->writeln('');

        return 0;
    }
}
