<?php

/**
 * @file
 * Application Entry Point.
 *
 * This file serves as the entry point for all HTTP requests coming into the
 * application. It's responsible for bootstrapping the Symfony application by
 * initializing the Kernel, which manages the environment and configuration.
 *
 * The autoload_runtime.php file is included to set up the Composer autoloading
 * mechanism, allowing the application to automatically load classes from the
 * vendor directory and other registered namespaces.
 *
 * The returned closure takes an array of context variables, such as the
 * environment ('APP_ENV') and debug mode ('APP_DEBUG'), and constructs a new
 * Kernel instance with these parameters. The Kernel then handles the request,
 * coordinating the application's response.
 */

use App\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
  return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
