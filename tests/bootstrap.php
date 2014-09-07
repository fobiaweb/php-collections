<?php
/**
 * bootstrap.php~.php file
 *
 * @author     Dmitriy Tyurin <fobia3d@gmail.com>
 * @copyright  Copyright (c) 2014 Dmitriy Tyurin
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

if (defined('TEST_BOOTSTRAP_FILE')) {
    return;
}
define('TEST_BOOTSTRAP_FILE', true);

$loader = null;

$autoloadFile = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadFile)) {
    throw new RuntimeException('Install dependencies to run phpunit.');
}

$loader = require_once $autoloadFile;
$loader->add('Fobia\\Collections\\Test', 'tests');
unset($autoloadFile);

// TODO: check include path INCLUDE_PATH%
// ini_set('include_path', ini_get('include_path'));

// put your code here
