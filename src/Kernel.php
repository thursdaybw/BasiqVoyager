<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Symfony Kernel.
 *
 * The Kernel class is the heart of the Symfony system. It manages an
 * environment that interacts with the bundles and various configuration
 * settings.
 *
 * By extending the BaseKernel and using the MicroKernelTrait, this class is
 * responsible for bootstrapping the application, handling requests, and
 * controlling the overall workflow. It's a central piece that ties together
 * the application's configuration, bundles, and runtime processes.
 */
class Kernel extends BaseKernel {
  use MicroKernelTrait;

}
