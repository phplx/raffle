<?php

/*
 * This file is part of phplx Raffle.
 *
 * (c) 2013 phplx.net
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__ . '/../vendor/autoload.php';

use phplx\Raffle\App;

if (count($argv) < 2) {
    die(sprintf("Usage: %s prize\n", $argv[0]));
}

$prize = implode(' ', array_slice($argv, 1));

$raffle = new App();
$raffle->setPrize($prize);

try {
    $raffle->run();
} catch (\Exception $e) {
    die(sprintf("An error occurred: %s\n", $e->getMessage()));
}
