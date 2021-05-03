<?php

namespace App;

use League\CommonMark\CommonMarkConverter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class GeneratorCommand extends Command
{
    protected static $defaultName = 'generate';

    /** @var Environment */
    protected  $twig;

    /**
     * GeneratorCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $loader = new FilesystemLoader(__DIR__ . '/resources/twig/default');
        $this->twig = new Environment($loader, []);
    }


    protected function configure(): void
    {
        $this->setDescription('Generate html from your current TILs');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tils = $this->findTils('tils');

        $outputPath = '_output';
        @mkdir($outputPath);
        $this->generatePosts($tils, $outputPath);
        $this->generateIndex($tils, $outputPath);

        return Command::SUCCESS;
    }

    protected function findTils(string $dir): array
    {
        $finder = new Finder();
        $finder->files()->in($dir)->name('*.md');

        $tils = [];
        foreach ($finder as $file) {
            $section = $file->getRelativePath();

            if (!isset($section)) {
                $tils[$section] = [];
            }

            $content = file_get_contents($file->getPathname());

            $title = $file->getFilename();
            if (preg_match("/^#\s+(.*)$/m", $content, $match)) {
                $title = $match[1];
            }

            $tils[$section][] = [
                'filename' => $file->getPathname(),
                'url' => $section . '/' . $file->getFilenameWithoutExtension() . '.html',
                'title' => $title,
            ];
        }

        ksort($tils);

        return $tils;
    }

    protected function generateIndex(array $tils, string $path)
    {
        $template = $this->twig->load("index.html.twig");

        $count = 0;
        foreach ($tils as $v) {
            $count += count($v);
        }

        $out = $template->render(['count' => $count, 'tils' => $tils]);
        file_put_contents($path . '/index.html', $out);
    }

    protected function generatePosts(array $tils, string $path)
    {
        $converter = new CommonMarkConverter([
            'allow_unsafe_links' => true,
        ]);

        foreach ($tils as $section => $entries) {
            @mkdir($path . '/'. $section);

            foreach ($entries as $til) {
                $content = file_get_contents($til['filename']);

                $html = $converter->convertToHtml($content);

                $template = $this->twig->load("til.html.twig");
                $out = $template->render([
                    'title' => $til['title'],
                    'content' => $html,
                ]);

                file_put_contents($path.'/'.$til['url'], $out);
            }
        }
    }
}
