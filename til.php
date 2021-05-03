<?php

use App\GeneratorCommand;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

const VERSION = '1.0.0';

$app = new Application('TodayILearnedGenerator', VERSION);
$app->add(new GeneratorCommand());

$app->setCatchExceptions(false);
$app->run();
