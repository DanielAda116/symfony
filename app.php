<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 18.10.2017
 * Time: 11:30
 */

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands

$application->run();