<?php

use App\GeneratorCommand;
use App\ListThemesCommand;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

const VERSION = '1.0.1';

$app = new Application('TodayILearnedGenerator', VERSION);
$app->add(new GeneratorCommand());
$app->add(new ListThemesCommand());

$app->setCatchExceptions(false);
$app->run();
