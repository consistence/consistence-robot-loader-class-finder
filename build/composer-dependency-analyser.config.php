<?php

declare(strict_types = 1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

$config = $config->enableAnalysisOfUnusedDevDependencies();
$config = $config->addPathToScan(__DIR__, true);

// pinned specific package versions
$config = $config->ignoreErrorsOnPackages([
	'nette/finder', // before 2.4 did not work with PHP 7.2
	'nette/utils', // before 2.5 did not work with PHP 7.2
], [ErrorType::UNUSED_DEPENDENCY]);

// tools
$config = $config->ignoreErrorsOnPackages([
	'consistence/coding-standard',
	'phing/phing',
	'php-parallel-lint/php-console-highlighter',
	'php-parallel-lint/php-parallel-lint',
], [ErrorType::UNUSED_DEPENDENCY]);

return $config;
